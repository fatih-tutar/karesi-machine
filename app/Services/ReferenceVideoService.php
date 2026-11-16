<?php

namespace App\Services;

use App\Models\Machine;
use App\Support\Youtube;
use Throwable;

class ReferenceVideoService
{
    /**
     * Reference videos from the machines table (YouTube id + label, unique by id),
     * ordered by sort_order descending.
     *
     * @return list<array{id:string,label:string}>
     */
    public function all(): array
    {
        $seen = [];
        $videos = [];

        try {
            $machines = Machine::query()
                ->where('is_deleted', false)
                ->whereNotNull('video_url')
                ->where('video_url', '!=', '')
                ->orderByDesc('sort_order')
                ->orderByDesc('id')
                ->get(['name', 'video_url']);
        } catch (Throwable) {
            return [];
        }

        foreach ($machines as $machine) {
            $id = Youtube::extractId($machine->video_url);

            if ($id && ! isset($seen[$id])) {
                $seen[$id] = true;
                $videos[] = [
                    'id' => $id,
                    'label' => $machine->name !== '' ? (string) $machine->name : 'Video',
                ];
            }
        }

        return $videos;
    }
}
