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
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('display_name')->nullable()->after('name');
            $table->string('description')->nullable()->after('display_name');
            $table->boolean('is_menu')->default(false)->after('description');
            $table->string('menu_icon')->nullable()->after('is_menu');
            $table->string('menu_route')->nullable()->after('menu_icon');
            $table->integer('menu_order')->default(0)->after('menu_route');
            $table->unsignedBigInteger('parent_id')->nullable()->after('menu_order');
            
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('permissions')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn([
                'display_name',
                'description',
                'is_menu',
                'menu_icon',
                'menu_route',
                'menu_order',
                'parent_id'
            ]);
        });
    }
};
