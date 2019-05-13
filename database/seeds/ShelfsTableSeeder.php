<?php

use Illuminate\Database\Seeder;
use App\Shelfs;

class ShelfsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Shelfs::class,3)->create();
    }
}
