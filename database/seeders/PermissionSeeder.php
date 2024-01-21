<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'OWNER']);
        Role::create(['name' => 'MEMBER']);
        Role::create(['name' => 'VIEWER']);

        Permission::create(['name' => 'read-project']);
        Permission::create(['name' => 'update-project']);
        Permission::create(['name' => 'delete-project']);

        Permission::create(['name' => 'read-task']);
        Permission::create(['name' => 'create-task']);
        Permission::create(['name' => 'update-task']);
        Permission::create(['name' => 'delete-task']);

        Permission::create(['name' => 'read-subtask']);
        Permission::create(['name' => 'create-subtask']);
        Permission::create(['name' => 'update-subtask']);
        Permission::create(['name' => 'delete-subtask']);

        $owner = Role::findByName('OWNER');
        foreach (Permission::all() as $permission) {
            $owner->givePermissionTo(permissions: $permission->name);
        }

        $member = Role::findByName('MEMBER');

        $member->syncPermissions([
            'read-project',
            'read-task',
            'create-task',
            'update-task',
            'delete-task',
            'read-subtask',
            'create-subtask',
            'update-subtask',
            'delete-subtask',
        ]);

        $viewer = Role::findByName('VIEWER');

        $viewer->syncPermissions([
            'read-project',
            'read-task',
            'read-subtask',
        ]);
    }
}
