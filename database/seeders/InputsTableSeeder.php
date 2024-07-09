<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Input;
use App\Models\Campaign;

class InputsTableSeeder extends Seeder
{
    public function run()
    {
        // Get some campaigns
        $campaigns = Campaign::all();

        foreach ($campaigns as $campaign) {
            Input::create([
                'campaign_id' => $campaign->id,
                'type' => 'channel',
                'value' => 'Facebook',
            ]);

            Input::create([
                'campaign_id' => $campaign->id,
                'type' => 'source',
                'value' => 'Ad',
            ]);

            Input::create([
                'campaign_id' => $campaign->id,
                'type' => 'campaign_name',
                'value' => 'Summer Sale',
            ]);

            Input::create([
                'campaign_id' => $campaign->id,
                'type' => 'target_url',
                'value' => 'http://facebookcampaign.com',
            ]);
        }
    }
}
