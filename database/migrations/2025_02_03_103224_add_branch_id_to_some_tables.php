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
            'client_payment_settings',
            'destruction',
            'destruction_details',
            'esalats',
            'head_back_purchases',
            'head_back_purchases_details',
            'head_back_sales',
            'head_back_sales_details',
            'item_installation_details',
            'item_installations',
            'orders',
            'product_adjustments',
            'production_details',
            'production_materials',
            'productions',
            'productive',
            'purchases',
            'purchases_details',
            'representative_clients',
            'sales',
            'sales_details',
            'supplier_vouchers',
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
                $table->unsignedBigInteger('publisher_id')->nullable()->index("{$tableName}_publisher_index")->after('branch_id');
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
            'client_payment_settings',
            'destruction',
            'destruction_details',
            'esalats',
            'head_back_purchases',
            'head_back_purchases_details',
            'head_back_sales',
            'head_back_sales_details',
            'item_installation_details',
            'item_installations',
            'orders',
            'product_adjustments',
            'production_details',
            'production_materials',
            'productions',
            'productive',
            'purchases',
            'purchases_details',
            'representative_clients',
            'sales',
            'sales_details',
            'supplier_vouchers',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                // Get the proper foreign key name
                $foreignKey = "{$tableName}_branch_id_foreign";

                // Drop the foreign key if it exists
                if (Schema::hasColumn($tableName, 'branch_id')) {
                    $foreignKeys = Schema::getConnection()
                        ->getDoctrineSchemaManager()
                        ->listTableForeignKeys($tableName);

                    foreach ($foreignKeys as $key) {
                        if (in_array('branch_id', $key->getLocalColumns())) {
                            $table->dropForeign($key->getName());
                            break;
                        }
                    }

                    // Then drop the column
                    $table->dropColumn('branch_id');
                    $table->dropColumn('publisher_id');
                }
            });
        }
    }
};
