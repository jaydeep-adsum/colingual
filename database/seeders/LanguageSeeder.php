<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            ['language' => 'English'],
            ['language' => 'Spanish'],
            ['language' => 'French'],
            ['language' => 'Persian'],
            ['language' => 'Hindi'],
            ['language' => 'Gujarati'],
        ];
        foreach($languages as $language){
            Language::create($language);
        }
    }
}
