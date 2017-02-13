<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		User::truncate();

		//foreach(range(1, 10) as $index)
		//{
		//	User::create([
		//
		//	]);
		//}
		User::create(array('username' => 'root', 'password' => Hash::make('123456'), 'display_name' => 'Admin'));
	}

}