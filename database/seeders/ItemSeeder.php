<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Items;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'name' => 'Kulkas',
                'price' => '3000000',
                'cost' => '200000',
            ],
            [
                'name' => 'Lemari',
                'price' => '4000000',
                'cost' => '100000',
            ],
            [
                'name' => 'Meja',
                'price' => '2000000',
                'cost' => '50000',
            ],
       ];

       DB::table('items')->insert($items);

    }
}
