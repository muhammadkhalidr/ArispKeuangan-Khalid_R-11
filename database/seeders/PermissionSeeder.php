<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::updateOrCreate(
            [
                'name' => 'admin',
            ],
            [
                'name' => 'admin'
            ]
        );
        $role_owner = Role::updateOrCreate(
            [
                'name' => 'owner',
            ],
            [
                'name' => 'owner'
            ]
        );

        $permission = Permission::updateOrCreate(
            [
                'name' => 'orderan.data',
                'name' => 'pengeluaran.data',
                'name' => 'pembelian.data',
            ],
            [
                'name' => 'orderan.data',
                'name' => 'pengeluaran.data',
                'name' => 'pembelian.data',
            ]
        );
        $permission2 = Permission::updateOrCreate(
            [
                'name' => 'pengguna.data',
            ],
            [
                'name' => 'pengguna.data'
            ]
        );

        $role_admin->givePermissionTo($permission);
        $role_owner->givePermissionTo($permission2);

        // $admin = User::find(1);
        // $owner = User::find(2);
        // $admin->assignRole('admin');
        // $owner->assignRole('owner');

        $users = User::where('level', 1)->orWhere('level', 2)->get();

        foreach ($users as $user) {
            if ($user->level == 1) {
                $user->assignRole('admin');
            } else if ($user->level == 2) {
                $user->assignRole('owner');
            }
        }
    }
}
