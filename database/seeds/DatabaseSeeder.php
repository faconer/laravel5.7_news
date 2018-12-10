<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //tao du lieu mau
    	/*$this->call('ProductTableSeeder');*/
    }
}


/*class ProductTableSeeder extends Seeder
{
    DB::table('product')->insert([
    	array('name'=>'Aophong', 'price'=>'100000'),
    	array('name'=>'Aophong', 'price'=>'100000'),
    	array('name'=>'Aophong', 'price'=>'100000')
    ])
}
*/