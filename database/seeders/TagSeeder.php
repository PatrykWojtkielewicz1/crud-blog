<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['Psy', 'Koty', 'Zwierzęta', 'Porady', 'Ciekawostki', 'Podróże', 'Kawa', 'Jedzenie'];
        foreach($tags as $tag){
            Tag::create([
                'name' => $tag,
            ]);   
        }
    }
}
