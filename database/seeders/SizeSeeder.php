<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Size;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
        $sizes = array_map('str_getcsv', file('resources/csv/sizes.csv'));

        foreach($sizes as $size){
            Size::create([
                'code' => $size[0],
            ]);
        }
    }

}
