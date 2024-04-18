<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $superAdminRole=Role::create(['name'=>'super-admin']);
        $managerRole=Role::create(['name'=>'manager']);
        $userRole=Role::create(['name'=>'user']);

       $userSuperAdmin=User::create([
        'name'=>'superadmin',
        'email'=>'superadmin@gmail.com',
        'password'=>Hash::make('superadmin@1234'),

       ]);
       $userManager=User::create([
        'name'=>'manager',
        'email'=>'manager@gmail.com',
        'password'=>Hash::make('manager@123')

       ]);
       $user=User::create([
        'name'=>'testuser',
        'email'=>'testuser@gmail.com',
        'password'=>Hash::make('testuser@123')

       ]);
       $userSuperAdmin->assignRole($superAdminRole);
       $userManager->assignRole($managerRole);
       $user->assignRole($userRole);




    }
}
