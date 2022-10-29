<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();                      

        $roleAdminComercioDistribuidor = Role::firstOrCreate(['guard_name' => 'api', 'name' => 'admin']);    
        $permissions = [
            Permission::firstOrCreate(['guard_name' => 'api','name' => 'comercio.crear']),
            Permission::firstOrCreate(['guard_name' => 'api','name' => 'comercio.actualizar']),
            Permission::firstOrCreate(['guard_name' => 'api','name' => 'comercio.visualizar']),
            Permission::firstOrCreate(['guard_name' => 'api','name' => 'comercio.eliminar'])
        ];      
        $roleAdminComercioDistribuidor->givePermissionTo($permissions);  

        $password = Hash::make('secret');

        $user = new \App\Models\User();
        $user->email = 'germaneherrera@gmail.com';
        $user->password = $password;
        $user->save();

        $password = Hash::make('secret');

        $user = new \App\Models\User();
        $user->email = 'jhomove@gmail.com';
        $user->password = $password;
        $user->save();

        $user->assignRole('admin');
    }
}
