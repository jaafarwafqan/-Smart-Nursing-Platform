<?php

namespace Tests\Unit;

use App\Models\Research;
use App\Services\ResearchService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResearchServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_research()
    {
        $service = app(ResearchService::class);
        $data = [
            'title' => 'بحث اختبار',
            'research_type' => 'qualitative',
            'publication_status' => 'draft',
        ];
        $extra = [];
        $research = $service->create($data, $extra);
        $this->assertInstanceOf(Research::class, $research);
        $this->assertEquals('بحث اختبار', $research->title);
    }

    public function test_update_research()
    {
        $service = app(ResearchService::class);
        $research = Research::factory()->create(['title' => 'قديم']);
        $service->update($research, ['title' => 'جديد'], []);
        $this->assertEquals('جديد', $research->fresh()->title);
    }

    public function test_delete_research()
    {
        $service = app(ResearchService::class);
        $research = Research::factory()->create();
        $result = $service->delete($research);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('researches', ['id' => $research->id]);
    }
} 