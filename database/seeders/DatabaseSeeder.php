<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

//////////////////////// Users //////////////////////////
        $this->call(UsersTableSeeder::class);
        \App\Models\User::factory([
            [
                'name' => 'Admin',
                'username' => 'Admin',
                'guid' => '841d5bc6-5bab-453e-8f0b-b74ee43dc2da',
                'domain' => 'default',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'pato',
                'username' =>'pato',
                'guid' => '207970ce-fddd-42f7-82a1-c0e6656f8247',
                'domain' => 'default',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'michael',
                'username' => 'michael',
                'guid' => '7029b7c7-1b43-47b9-aacc-c4bc3e5a42ac',
                'domain' => 'default',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'simon',
                'username' => 'simon',
                'guid' => '827cc32c-2ed4-4f44-b40a-02fc5ba6971c',
                'domain' => 'default',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

///////////////////////////Parent Folder /////////////////////////////////////////
        $this->call(FoldersTableSeeder::class);
        \App\Models\Folder::factory([
            'name' => 'Repository',
            'path' => '/home',
            'parent_folder_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

//////////////////////////// Groups ////////////////////////////////
        $this->call(GroupsTableSeeder::class);
        \App\Models\Group::factory([
            [
            'group_name' => 'admin_group',
            'group_admin_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
            ],

            [
            'group_name' => 'devs_group',
            'group_admin_id' => '2',
            'created_at' => now(),
            'updated_at' => now(),
            ],
        ]);

//////////////////// Group Memberships///////////////////////////
        $this->call(GroupMembershipsTableSeeder::class);
        \App\Models\GroupMembership::factory([
            [
                'group_id' => '1',
                'user_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
                ],
    
                [
                'group_id' => '2',
                'user_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
                ],
    
                [
                'group_id' => '2',
                'user_id' => '3',
                'created_at' => now(),
                'updated_at' => now(),
                ],
    
                [
                'group_id' => '2',
                'user_id' => '4',
                'created_at' => now(),
                'updated_at' => now(),
                ],
    
        ]);

//////////////////////// Group Permissions /////////////////////////////

        $this->call(GroupPermissionsTableSeeder::class);
        \App\Models\GroupPermission::factory([
            'group_id' => '1',
            'folder_id' => '1',
            'view_users' => '1',
            'add_user' => '1',
            'assign_user_group' => '1',
            'view_user' => '1',
            'update_user' => '1',
            'delete_user' => '1',
            'view_groups' => '1',
            'add_group' => '1',
            'view_group' => '1',
            'update_group' => '1',
            'delete_group' => '1',
            'view_group_memberships' => '1',
            'add_group_membership' => '1',
            'view_group_membership' => '1',
            'update_group_membership' => '1',
            'delete_group_membership' => '1',
            'view_group_permissions' => '1',
            'add_group_permission' => '1',
            'view_group_permission' => '1',
            'update_group_permission' => '1',
            'delete_group_permission' => '1',
            'view_folders' => '1',
            'create_folder' => '1',
            'open_folder' => '1',
            'update_folder' => '1',
            'delete_folder' => '1',
            'view_documents' => '1',
            'add_document' => '1',
            'view_document' => '1',
            'update_document' => '1',
            'delete_document' => '1',
            'view_fields' => '1',
            'add_field' => '1',
            'view_field' => '1',
            'update_field' => '1',
            'delete_field' => '1',
            'view_docfields' => '1',
            'create_docfield' => '1',
            'view_docfield' => '1',
            'update_docfield' => '1',
            'delete_docfield' => '1',
            'view_worksteps' => '1',
            'add_workstep' => '1',
            'view_workstep' => '1',
            'update_workstep' => '1',
            'delete_workstep' => '1',
            'view_possible_actions' => '1',
            'add_possible_action' => '1',
            'view_possible_action' => '1',
            'update_possible_action' => '1',
            'delete_possible_action' => '1',
            'view_workstep_results' => '1',
            'add_workstep_result' => '1',
            'view_workstep_result' => '1',
            'rewind_workstep_result' => '1',
            'delete_workstep_result' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
