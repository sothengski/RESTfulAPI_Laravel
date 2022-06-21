<?php

namespace Database\Seeders;

use App\Model\Category;
use App\Model\Product;
use App\Model\Transaction;
use App\Model\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // $this->call(UsersTableSeeder::class);
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();

        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();


        DB::table('category_product')->truncate();

        $usersQuantity = 1000;
        $categoriesQuantity = 30;
        $productsQuantity = 1000;
        $transactionsQuantity = 1000;

        User::factory($usersQuantity)->create();
        Category::factory($categoriesQuantity)->create();

        Product::factory($productsQuantity)->create()->each(function ($product) {
            $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');
            $product->categories()->attach($categories);
        });
        Transaction::factory($transactionsQuantity)->create();

        // factory(User::class, $usersQuantity)->create();
        // factory(Category::class, $categoriesQuantity)->create();

        // factory(Product::class, $productsQuantity)->create()->each(
        //     function ($product) {
        //         $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');

        //         $product->categories()->attach($categories);
        //     }
        // );

        // factory(Transaction::class, $transactionsQuantity)->create();
    }
}