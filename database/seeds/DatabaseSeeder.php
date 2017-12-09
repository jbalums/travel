<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
    	$user = new \App\User;
        $user->name 	= 'Admin';
		$user->email 	= 'admin@gmail.com';
 		$user->password = bcrypt('admin');
 		$user->type  	= 'admin';
 		$user->save();
    }
}
