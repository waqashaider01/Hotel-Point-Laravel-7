<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Template::create([
            'hotel_settings_id' => 1,
            'name' => 'Test Check in Template',
            'template' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci blanditiis dolore dolores et ex exercitationem, expedita laboriosam magni minima nesciunt odio placeat quibusdam quisquam reiciendis sint soluta veritatis voluptate!',
            'type' => 'checkin',
        ]);
        Template::create([
            'hotel_settings_id' => 1,
            'name' => 'Test Check in Template 2',
            'template' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci blanditiis dolore dolores et ex exercitationem, expedita laboriosam magni minima nesciunt odio placeat quibusdam quisquam reiciendis sint soluta veritatis voluptate!',
            'type' => 'checkin',
        ]);
        Template::create([
            'hotel_settings_id' => 1,
            'name' => 'Test Check in Template 3',
            'template' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci blanditiis dolore dolores et ex exercitationem, expedita laboriosam magni minima nesciunt odio placeat quibusdam quisquam reiciendis sint soluta veritatis voluptate!',
            'type' => 'email',
        ]);
        Template::create([
            'hotel_settings_id' => 1,
            'name' => 'Test Check in Template 4',
            'template' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci blanditiis dolore dolores et ex exercitationem, expedita laboriosam magni minima nesciunt odio placeat quibusdam quisquam reiciendis sint soluta veritatis voluptate!',
            'type' => 'email',
        ]);
    }
}
