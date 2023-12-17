<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'AnwarElmetwaly', 
            'email' => 'anwarelmetwaly39@gmail.com',
            'password' => Hash::make('123456789abcdefgh'),
            'roles_name' => ["owner"],
            'Status' => 'مفعل',
            ]);
      
            $role = Role::create(['name' => 'owner']);
       
            $permissions = Permission::pluck('id','id')->all();
      
            $role->syncPermissions($permissions);
       
            $user->assignRole([$role->id]);
    
    }
}
