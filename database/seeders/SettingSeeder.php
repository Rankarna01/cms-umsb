<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'CMS Universitas'],
            ['key' => 'site_tagline', 'value' => 'Website Resmi Universitas Keren'],
            ['key' => 'site_logo', 'value' => null],
            ['key' => 'site_favicon', 'value' => null],
            ['key' => 'contact_address', 'value' => null],
            ['key' => 'contact_email', 'value' => null],
            ['key' => 'contact_phone', 'value' => null],
            ['key' => 'social_facebook', 'value' => null],
            ['key' => 'social_instagram', 'value' => null],
            ['key' => 'social_youtube', 'value' => null],
            ['key' => 'social_twitter', 'value' => null],
        ];

        DB::table('settings')->insert($settings);
    }
}
