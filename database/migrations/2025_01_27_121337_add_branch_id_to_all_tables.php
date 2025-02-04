<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = [
            'admins',
            'categories',
            'clients',
            'companies',
            'employees',
            'suppliers',
            'unites',
            'representatives',
            'zones_settings',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('id');

                // Add a unique foreign key name for each table
                $table->foreign('branch_id', "{$tableName}_branch_id_foreign")
                    ->references('id')
                    ->on('branches')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
                $table->unsignedBigInteger('publisher_id')->nullable()->index('unites_publisher_foreign')->after('branch_id');

            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = [
            'admins',
            'categories',
            'clients',
            'companies',
            'employees',
            'suppliers',
            'unites',
            'zones_settings',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                // Drop the foreign key first
                $table->dropForeign(["{$tableName}_branch_id_foreign"]);

                // Then drop the column
                $table->dropColumn('branch_id');
            });
        }
    }
};
