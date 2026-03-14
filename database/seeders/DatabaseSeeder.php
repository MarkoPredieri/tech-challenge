<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Article;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        //CREO 5 CATEGORIE
        $categories = Category::factory(5)->create();

        //CREO 20 ARTICOLI ASSEGNATI CASUALMENTE ALLE CATEGORIE PRECEDENTEMENTE CREATE
        Article::factory(20)->create([
            'category_id' => fn() => fake()->randomElement($categories->pluck('id')->toArray())
        ]);

        $this->call([
            BillSeeder::class,
            OfferSeeder::class,
        ]);
    }
}
