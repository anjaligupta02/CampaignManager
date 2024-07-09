<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Campaign;
use App\Models\Input;

class CampaignTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_campaign()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/campaigns', [
            'user_id' => $user->id,
            'inputs' => [
                ['type' => 'channel', 'value' => 'Facebook'],
                ['type' => 'source', 'value' => 'Ad'],
                ['type' => 'campaign_name', 'value' => 'Summer Sale'],
                ['type' => 'target_url', 'value' => 'http://example.com']
            ]
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'id', 'user_id', 'created_at', 'updated_at', 'inputs' => [
                         '*' => ['id', 'campaign_id', 'type', 'value', 'created_at', 'updated_at']
                     ]
                 ]);

        $this->assertCount(1, Campaign::all());
        $this->assertCount(4, Input::all());
    }
}
