<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('group_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('folder_id');

            $table->boolean('view_users')->default(false);
            $table->boolean('add_user')->default(false);
            $table->boolean('assign_user_group')->default(false);
            $table->boolean('view_user')->default(false);
            $table->boolean('update_user')->default(false);
            $table->boolean('delete_user')->default(false);

            $table->boolean('view_groups')->default(false);
            $table->boolean('add_group')->default(false);
            $table->boolean('view_group')->default(false);
            $table->boolean('update_group')->default(false);
            $table->boolean('delete_group')->default(false);

            $table->boolean('view_group_memberships')->default(false);
            $table->boolean('add_group_membership')->default(false);
            $table->boolean('view_group_membership')->default(false);
            $table->boolean('update_group_membership')->default(false);
            $table->boolean('delete_group_membership')->default(false);

            $table->boolean('view_group_permissions')->default(false);
            $table->boolean('add_group_permission')->default(false);
            $table->boolean('view_group_permission')->default(false);
            $table->boolean('update_group_permission')->default(false);
            $table->boolean('delete_group_permission')->default(false);

            $table->boolean('view_folders')->default(false);
            $table->boolean('create_folder')->default(false);
            $table->boolean('open_folder')->default(false);
            $table->boolean('update_folder')->default(false);
            $table->boolean('delete_folder')->default(false);

            $table->boolean('view_documents')->default(false);
            $table->boolean('add_document')->default(false);
            $table->boolean('view_document')->default(false);
            $table->boolean('update_document')->default(false);
            $table->boolean('delete_document')->default(false);

            $table->boolean('view_fields')->default(false);
            $table->boolean('add_field')->default(false);
            $table->boolean('view_field')->default(false);
            $table->boolean('update_field')->default(false);
            $table->boolean('delete_field')->default(false);

            $table->boolean('view_docfields')->default(false);
            $table->boolean('create_docfield')->default(false);
            $table->boolean('view_docfield')->default(false);
            $table->boolean('update_docfield')->default(false);
            $table->boolean('delete_docfield')->default(false);

            $table->boolean('view_worksteps')->default(false);
            $table->boolean('add_workstep')->default(false);
            $table->boolean('view_workstep')->default(false);
            $table->boolean('update_workstep')->default(false);
            $table->boolean('delete_workstep')->default(false);

            $table->boolean('view_possible_actions')->default(false);
            $table->boolean('add_possible_action')->default(false);
            $table->boolean('view_possible_action')->default(false);
            $table->boolean('update_possible_action')->default(false);
            $table->boolean('delete_possible_action')->default(false);

            $table->boolean('view_workstep_results')->default(false);
            $table->boolean('add_workstep_result')->default(false);
            $table->boolean('view_workstep_result')->default(false);
            $table->boolean('rewind_workstep_result')->default(false);
            $table->boolean('delete_workstep_result')->default(false);

            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('folder_id')->references('id')->on('folders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_permissions');
    }
};
