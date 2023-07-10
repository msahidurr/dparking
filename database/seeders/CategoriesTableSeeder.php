<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Place;
use App\User;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();
        $place = Place::first();
        Category::create([ 'place_id' => $place->id,'type' => 'Car', 'created_by' => $user->id]);
        Category::create([ 'place_id' => $place->id,'type' => 'Micro', 'created_by' => $user->id]);
        Category::create([ 'place_id' => $place->id,'type' => 'Pickup', 'created_by' => $user->id]);
        Category::create([ 'place_id' => $place->id,'type' => 'Bike', 'created_by' => $user->id]);
        Category::create([ 'place_id' => $place->id,'type' => 'Bicycle', 'created_by' => $user->id]);
    }
}
