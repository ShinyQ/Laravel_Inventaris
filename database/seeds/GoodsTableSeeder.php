<?php

use Illuminate\Database\Seeder;
use App\Goods;

class GoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Goods::class,3)->create();
    }
}
