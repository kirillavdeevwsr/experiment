<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert([
            'id'=>2,
            'name'=>'Админ',
            'full_name'=>'Админ',
            'email'=>'admin@admin.ru',
            'password'=>bcrypt('adminadmin'),
            'created_at'=>DB::raw('CURRENT_TIMESTAMP'),
            'updated_at'=>DB::raw('CURRENT_TIMESTAMP'),
        ]);
        DB::table('users')->insert([
            'id'=>1,
            'name'=>'Олег',
            'surname'=>'Агарков',
            'patronymic'=>'Владимирович',
            'full_name'=>'Олег Владимирович Агарков',
            'email'=>'oleg@ufaga.ru',
            'password'=>bcrypt('Kesh4you'),
            'created_at'=>DB::raw('CURRENT_TIMESTAMP'),
            'updated_at'=>DB::raw('CURRENT_TIMESTAMP'),
        ]);
        DB::table('users')->insert([
            'id'=>3,
            'name'=>'Рустем',
            'surname'=>'Абдюшев',
            'patronymic'=>'Мансурович',
            'full_name'=>'Рустем Мансурович Абдюшев',
            'email'=>'rm.abdyushev@gmail.com',
            'password'=>bcrypt('qzwxec123'),
            'created_at'=>DB::raw('CURRENT_TIMESTAMP'),
            'updated_at'=>DB::raw('CURRENT_TIMESTAMP'),
        ]);
    }
}
