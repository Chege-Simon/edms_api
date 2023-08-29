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
            $table->boolean('add_user')->default(false);
            $table->boolean('edit_user')->default(false);
            $table->boolean('delete_user')->default(false);
            $table->boolean('add_group')->default(false);
            $table->boolean('edit_group')->default(false);
            $table->boolean('delete_group')->default(false);
            $table->boolean('add_permission')->default(false);
            $table->boolean('edit_permission')->default(false);
            $table->boolean('delete_permission')->default(false);
            $table->boolean('assign_user_group')->default(false);
            $table->boolean('edit_user_group')->default(false);
            $table->boolean('view_folder')->default(false);
            $table->boolean('open_folder')->default(false);
            $table->boolean('edit_folder')->default(false);
            $table->boolean('delete_folder')->default(false);
            $table->boolean('create_nested_folder')->default(false);
            $table->boolean('edit_nested_folders')->default(false);
            $table->boolean('delete_nested_folders')->default(false);
            $table->boolean('add_document')->default(false);
            $table->boolean('edit_document')->default(false);
            $table->boolean('delete_document')->default(false);
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
