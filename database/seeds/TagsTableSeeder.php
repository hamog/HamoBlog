<?php

use App\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::create(['name' => 'php']);
        Tag::create(['name' => 'oop']);
        Tag::create(['name' => 'framework']);
        Tag::create(['name' => 'material']);
        Tag::create(['name' => 'design']);
    }
}
