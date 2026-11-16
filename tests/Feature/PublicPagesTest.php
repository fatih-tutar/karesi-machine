<?php

namespace Tests\Feature;

use App\Models\Machine;
use App\Support\Youtube;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_render(): void
    {
        foreach (['/', '/deneme', '/referanslar', '/iletisim'] as $uri) {
            $this->get($uri)->assertOk();
        }
    }

    public function test_reference_videos_come_from_machines_ordered_by_sort_order_desc(): void
    {
        $base = ['recorded_on' => now()->toDateString(), 'is_deleted' => false];

        Machine::create($base + ['name' => 'Low', 'video_url' => 'https://www.youtube.com/embed/aaaaaaaaaaa', 'sort_order' => 1]);
        Machine::create($base + ['name' => 'High', 'video_url' => 'https://youtube.com/embed/bbbbbbbbbbb', 'sort_order' => 9]);
        Machine::create(array_merge($base, ['name' => 'Deleted', 'video_url' => 'https://youtube.com/embed/DELETEDVID1', 'sort_order' => 5, 'is_deleted' => true]));

        $this->get('/referanslar')
            ->assertOk()
            ->assertSeeInOrder(['bbbbbbbbbbb', 'aaaaaaaaaaa'])
            ->assertDontSee('DELETEDVID1');
    }

    public function test_youtube_id_extraction(): void
    {
        $this->assertSame('abc123XYZ_-', Youtube::extractId('https://www.youtube.com/embed/abc123XYZ_-'));
        $this->assertSame('abc123XYZ_-', Youtube::extractId('https://www.youtube.com/watch?v=abc123XYZ_-&t=1'));
        $this->assertSame('abc123XYZ_-', Youtube::extractId('https://youtu.be/abc123XYZ_-'));
        $this->assertNull(Youtube::extractId('https://example.com/video'));
        $this->assertNull(Youtube::extractId(null));
    }
}
