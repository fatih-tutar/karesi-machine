<?php

namespace Tests\Feature;

use App\Models\AccountingEntry;
use App\Models\Company;
use App\Models\Machine;
use App\Models\Material;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AdminPagesTest extends TestCase
{
    use RefreshDatabase;

    private function entry(array $overrides = []): AccountingEntry
    {
        return AccountingEntry::create($overrides + [
            'type' => 0,
            'amount_try' => 1000,
            'amount_usd' => 25,
            'recorded_on' => '2026-01-15',
            'is_deleted' => false,
        ]);
    }

    private function fakePng(string $name): UploadedFile
    {
        // 1x1 transparent PNG (no GD needed).
        return UploadedFile::fake()->createWithContent(
            $name,
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg=='),
        );
    }

    private function seedDomain(): array
    {
        $date = ['recorded_on' => '2026-01-01', 'is_deleted' => false];
        $material = Material::create($date + ['name' => 'Bant', 'include_in_reports' => true]);
        $salary = Material::create($date + ['name' => 'Maaş']);
        $company = Company::create($date + ['name' => 'Acme']);
        $project = Project::create($date + ['name' => 'Hatay', 'include_in_reports' => true, 'show_in_profit_chart' => true]);

        return [$material, $salary, $company, $project];
    }

    public function test_admin_routes_require_authentication(): void
    {
        foreach (['/accounting', '/materials', '/companies', '/projects', '/finance', '/machines', '/dashboard'] as $uri) {
            $this->get($uri)->assertRedirect('/login');
        }
    }

    public function test_dashboard_redirects_to_accounting(): void
    {
        $this->actingAs(User::factory()->create())->get('/dashboard')->assertRedirect('/accounting');
    }

    public function test_all_admin_pages_render_with_data(): void
    {
        [$material, $salary, $company, $project] = $this->seedDomain();
        $this->entry(['material_id' => $material->id, 'company_id' => $company->id, 'project_id' => $project->id]);
        $this->entry(['type' => 1, 'amount_try' => 5000, 'project_id' => $project->id]);
        Machine::create(['name' => 'M1', 'recorded_on' => '2026-01-01', 'is_deleted' => false, 'sort_order' => 1]);

        Http::fake(['www.tcmb.gov.tr/*' => Http::response('', 404)]);

        $this->actingAs(User::factory()->create());

        foreach ([
            '/accounting', '/materials', '/companies', '/projects', '/machines',
            "/materials/{$material->id}", "/companies/{$company->id}", "/projects/{$project->id}",
            '/finance', '/finance?range=1y&currency=usd', '/finance?range=all&currency=try',
        ] as $uri) {
            $this->get($uri)->assertOk();
        }
    }

    public function test_accounting_crud_soft_delete_and_usd_rate(): void
    {
        [$material, , $company, $project] = $this->seedDomain();

        $xml = '<Tarih_Date><Currency CurrencyCode="USD"><ForexSelling>40,0000</ForexSelling></Currency></Tarih_Date>';
        Http::fake(['www.tcmb.gov.tr/*' => Http::response($xml, 200)]);

        $this->actingAs(User::factory()->create());

        $this->post('/accounting', [
            'type' => 0, 'material_id' => $material->id, 'amount_try' => '2000',
            'company_id' => $company->id, 'project_id' => $project->id, 'note' => 'n', 'description' => 'd',
        ])->assertRedirect('/accounting');

        $entry = AccountingEntry::first();
        $this->assertSame(2000, $entry->amount_try);
        $this->assertEquals(50.0, (float) $entry->amount_usd);
        $this->assertSame(now()->toDateString(), $entry->recorded_on->toDateString());

        $this->put("/accounting/{$entry->id}", [
            'type' => 1, 'material_id' => 0, 'amount_try' => '4000', 'company_id' => 0, 'project_id' => 0,
            'recorded_on' => '2026-02-10',
        ])->assertRedirect();

        $entry->refresh();
        $this->assertSame(1, $entry->type);
        $this->assertNull($entry->material_id);
        $this->assertEquals(100.0, (float) $entry->amount_usd);

        $this->delete("/accounting/{$entry->id}")->assertRedirect();
        $this->assertTrue($entry->fresh()->is_deleted);
        $this->assertDatabaseCount('accounting_entries', 1);
    }

    public function test_accounting_validation(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post('/accounting', ['type' => 5, 'amount_try' => 'abc'])
            ->assertSessionHasErrors(['type', 'amount_try']);
    }

    public function test_salary_multiplier_is_stored_in_session_and_applied_to_balance(): void
    {
        [, $salary] = $this->seedDomain();
        config(['tradeops.salary_material_id' => $salary->id]);

        $this->entry(['type' => 1, 'amount_try' => 10000]);
        $this->entry(['material_id' => $salary->id, 'amount_try' => 1000]);

        $this->actingAs(User::factory()->create());

        // default 1.8 => balance 10000 - 1800 = 8200 ; turnover 8200 + 1800 = 10000
        $this->get('/accounting')->assertOk()->assertSee('8.200,00')->assertSee('10.000,00');

        $this->post('/accounting/salary-multiplier', ['salary_multiplier' => '2'])->assertRedirect('/accounting');
        $this->assertSame(2.0, session('salary_multiplier'));

        $this->get('/accounting')->assertSee('8.000,00');
    }

    public function test_crud_for_materials_companies_projects(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post('/materials', ['name' => 'Yeni'])->assertRedirect('/materials');
        $material = Material::first();
        $this->put("/materials/{$material->id}", ['name' => 'Yeni2', 'include_in_reports' => 1])->assertRedirect('/materials');
        $this->assertTrue($material->fresh()->include_in_reports);
        $this->delete("/materials/{$material->id}")->assertRedirect('/materials');
        $this->assertTrue($material->fresh()->is_deleted);
        $this->get("/materials/{$material->id}")->assertNotFound();

        $this->post('/companies', ['name' => 'Firma'])->assertRedirect('/companies');
        $company = Company::first();
        $this->put("/companies/{$company->id}", ['name' => 'Firma2'])->assertRedirect('/companies');
        $this->assertSame('Firma2', $company->fresh()->name);
        $this->delete("/companies/{$company->id}");
        $this->assertTrue($company->fresh()->is_deleted);

        $this->post('/projects', ['name' => 'Proje'])->assertRedirect('/projects');
        $project = Project::first();
        $this->put("/projects/{$project->id}", [
            'name' => 'Proje2', 'recorded_on' => '2026-03-01', 'is_sold' => 1, 'show_in_profit_chart' => 1,
        ])->assertRedirect('/projects');
        $project->refresh();
        $this->assertTrue($project->is_sold);
        $this->assertTrue($project->show_in_profit_chart);
        $this->assertFalse($project->include_in_reports);
        $this->delete("/projects/{$project->id}");
        $this->assertTrue($project->fresh()->is_deleted);
    }

    public function test_machine_crud_with_image_upload(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post('/machines', [
            'name' => 'Sim', 'video_url' => 'https://youtube.com/embed/abcdefghijk', 'speed' => '2000',
            'weight_info' => '100 gr', 'image' => $this->fakePng('m.png'),
        ])->assertRedirect('/machines');

        $machine = Machine::first();
        $this->assertNotEmpty($machine->image);
        $this->assertFileExists(public_path('img/'.$machine->image));

        $this->put("/machines/{$machine->id}", ['name' => 'Sim2', 'sort_order' => 7, 'image' => $this->fakePng('n.png')])
            ->assertRedirect('/machines');
        $machine->refresh();
        $this->assertSame('Sim2', $machine->name);
        $this->assertSame(7, $machine->sort_order);
        $this->assertCount(2, explode(',', $machine->image));

        $this->post('/machines', ['name' => 'Bad', 'image' => UploadedFile::fake()->create('x.pdf', 10, 'application/pdf')])
            ->assertSessionHasErrors('image');

        foreach (explode(',', $machine->image) as $file) {
            File::delete(public_path('img/'.$file));
        }

        $this->delete("/machines/{$machine->id}")->assertRedirect('/machines');
        $this->assertTrue($machine->fresh()->is_deleted);
    }
}
