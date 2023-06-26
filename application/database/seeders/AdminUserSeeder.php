<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
			'role_id'=>1,
			'approve'=>1,
			'name'=>'admin',
			'email'=>'admin@admin.com',
			'email_verified_at'=> now(),
			'normal_password'=> 'adminpass',
			'password'=> bcrypt('adminpass')
		]);
		
		Role::create([
			'name'=>'Admin',
		]);
		
		Role::create([
			'name'=>'User',
		]);
    }
}
