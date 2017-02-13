<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class AppUserTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		AppUser::truncate();

		//foreach(range(1, 10) as $index)
		//{
		//	User::create([
		//
		//	]);
		//}
		AppUser::create(array('app_username' => 'arin', 'app_password' => '1234'));
		AppUser::create(array('app_username' => 'abcd', 'app_password' => 'abcd'));
		AppUser::create(array('app_username' => 'susim', 'app_password' => 'sus@123'));
	}

}