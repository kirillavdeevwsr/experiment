<?php

use Illuminate\Database\Seeder;

class SliderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sliders')->delete();
        DB::table('sliders')->insert([
            'id'=>1,
            'link'=>'/img/slider-img-1.jpg',
            'status'=>1,
            'created_at'=>DB::raw('CURRENT_TIMESTAMP'),
            'updated_at'=>DB::raw('CURRENT_TIMESTAMP'),
       ]);
    }
}
