<?php

namespace App\Console\Commands;

use App\Models\AccountingEntry;
use App\Models\Company;
use App\Models\Machine;
use App\Models\Material;
use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportLegacyCsv extends Command
{
    protected $signature = 'tradeops:import-legacy
                            {--path=database/data/legacy : Directory containing km-*.csv files}
                            {--fresh : Truncate domain tables before import}';

    protected $description = 'Import Karesi Makine legacy CSV exports into TradeOps tables';

    public function handle(): int
    {
        $path = base_path(rtrim((string) $this->option('path'), '/'));

        if (! is_dir($path)) {
            $this->error("Path not found: {$path}");

            return self::FAILURE;
        }

        $files = [
            'companies' => $path.'/km-clients.csv',
            'projects' => $path.'/km-customers.csv',
            'materials' => $path.'/km-products.csv',
            'machines' => $path.'/km-machines.csv',
            'accounting_entries' => $path.'/km-accounting.csv',
        ];

        foreach ($files as $label => $file) {
            if (! is_file($file)) {
                $this->error("Missing CSV: {$file}");

                return self::FAILURE;
            }
        }

        if ($this->option('fresh')) {
            if (DB::getDriverName() === 'pgsql') {
                DB::statement('TRUNCATE accounting_entries, machines, materials, projects, companies RESTART IDENTITY CASCADE');
            } else {
                Schema::disableForeignKeyConstraints();
                AccountingEntry::query()->delete();
                Machine::query()->delete();
                Material::query()->delete();
                Project::query()->delete();
                Company::query()->delete();
                Schema::enableForeignKeyConstraints();
            }
            $this->warn('Domain tables truncated.');
        }

        DB::transaction(function () use ($files) {
            $this->importCompanies($files['companies']);
            $this->importProjects($files['projects']);
            $this->importMaterials($files['materials']);
            $this->importMachines($files['machines']);
            $this->importAccountingEntries($files['accounting_entries']);
        });

        $this->resetPostgresSequences([
            'companies',
            'projects',
            'materials',
            'machines',
            'accounting_entries',
        ]);

        $this->table(
            ['Table', 'Rows'],
            [
                ['companies', Company::query()->count()],
                ['projects', Project::query()->count()],
                ['materials', Material::query()->count()],
                ['machines', Machine::query()->count()],
                ['accounting_entries', AccountingEntry::query()->count()],
            ]
        );

        $this->info('Legacy CSV import completed.');

        return self::SUCCESS;
    }

    private function importCompanies(string $file): void
    {
        $count = 0;
        foreach ($this->rows($file) as $row) {
            Company::query()->updateOrCreate(
                ['id' => (int) $row['id']],
                [
                    'name' => $row['name'],
                    'recorded_on' => $row['date'],
                    'is_deleted' => (bool) (int) $row['is_deleted'],
                ]
            );
            $count++;
        }
        $this->line("companies: {$count}");
    }

    private function importProjects(string $file): void
    {
        $count = 0;
        foreach ($this->rows($file) as $row) {
            Project::query()->updateOrCreate(
                ['id' => (int) $row['id']],
                [
                    'name' => $row['name'],
                    'recorded_on' => $row['date'],
                    'include_in_reports' => (bool) (int) $row['include_in_reports'],
                    'show_in_profit_chart' => (bool) (int) $row['show_in_profit_chart'],
                    'is_sold' => (bool) (int) $row['is_sold'],
                    'is_deleted' => (bool) (int) $row['is_deleted'],
                ]
            );
            $count++;
        }
        $this->line("projects: {$count}");
    }

    private function importMaterials(string $file): void
    {
        $count = 0;
        foreach ($this->rows($file) as $row) {
            Material::query()->updateOrCreate(
                ['id' => (int) $row['id']],
                [
                    'name' => $row['name'],
                    'recorded_on' => $row['date'],
                    'include_in_reports' => (bool) (int) $row['include_in_reports'],
                    'is_deleted' => (bool) (int) $row['is_deleted'],
                ]
            );
            $count++;
        }
        $this->line("materials: {$count}");
    }

    private function importMachines(string $file): void
    {
        $count = 0;
        foreach ($this->rows($file) as $row) {
            Machine::query()->updateOrCreate(
                ['id' => (int) $row['id']],
                [
                    'name' => $row['name'],
                    'image' => $this->nullableString($row['image'] ?? null),
                    'video_url' => $this->nullableString($row['video'] ?? null),
                    'speed' => $this->nullableString($row['speed'] ?? null),
                    'length' => $this->nullableString($row['length'] ?? null),
                    'height' => $this->nullableString($row['height'] ?? null),
                    'width' => $this->nullableString($row['width'] ?? null),
                    'weight_info' => $this->nullableString($row['gram'] ?? null),
                    'recorded_on' => $row['date'],
                    'is_deleted' => (bool) (int) $row['is_deleted'],
                    'sort_order' => (int) $row['ordering'],
                ]
            );
            $count++;
        }
        $this->line("machines: {$count}");
    }

    private function importAccountingEntries(string $file): void
    {
        $materialIds = Material::query()->pluck('id')->all();
        $companyIds = Company::query()->pluck('id')->all();
        $projectIds = Project::query()->pluck('id')->all();

        $count = 0;
        foreach ($this->rows($file) as $row) {
            $materialId = $this->nullableFk((int) $row['product_id'], $materialIds);
            $companyId = $this->nullableFk((int) $row['client_id'], $companyIds);
            $projectId = $this->nullableFk((int) $row['customer_id'], $projectIds);

            AccountingEntry::query()->updateOrCreate(
                ['id' => (int) $row['id']],
                [
                    'type' => (int) $row['type'],
                    'note' => $this->nullableString($row['info'] ?? null),
                    'material_id' => $materialId,
                    'description' => $this->nullableString($row['description'] ?? null),
                    'amount_try' => (int) $row['amount_try'],
                    'amount_usd' => $row['amount_usd'],
                    'company_id' => $companyId,
                    'project_id' => $projectId,
                    'recorded_on' => $row['date'],
                    'is_deleted' => (bool) (int) $row['is_deleted'],
                ]
            );
            $count++;
        }
        $this->line("accounting_entries: {$count}");
    }

    /**
     * @return \Generator<int, array<string, string>>
     */
    private function rows(string $file): \Generator
    {
        $handle = fopen($file, 'r');
        if ($handle === false) {
            throw new \RuntimeException("Unable to open {$file}");
        }

        try {
            $headers = fgetcsv($handle);
            if ($headers === false) {
                return;
            }

            $headers = array_map(static fn (string $h): string => trim($h, "\" \t\n\r\0\x0B"), $headers);

            while (($data = fgetcsv($handle)) !== false) {
                if ($data === [null] || $data === false) {
                    continue;
                }

                if (count($data) < count($headers)) {
                    $data = array_pad($data, count($headers), null);
                }

                yield array_combine($headers, $data);
            }
        } finally {
            fclose($handle);
        }
    }

    private function nullableString(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim($value);

        return $value === '' ? null : $value;
    }

    /**
     * @param  list<int|string>  $existingIds
     */
    private function nullableFk(int $id, array $existingIds): ?int
    {
        if ($id <= 0) {
            return null;
        }

        return in_array($id, $existingIds, false) ? $id : null;
    }

    /**
     * @param  list<string>  $tables
     */
    private function resetPostgresSequences(array $tables): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        foreach ($tables as $table) {
            DB::statement("
                SELECT setval(
                    pg_get_serial_sequence('{$table}', 'id'),
                    COALESCE((SELECT MAX(id) FROM {$table}), 1),
                    true
                )
            ");
        }
    }
}
