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
        Schema::table('sales_details', function (Blueprint $table) {
            $table->dropColumn('batch_number');
            $table->unsignedBigInteger('size_id')->nullable()->after('discount_percentage');
            $table->foreign('size_id')
                ->references('id')
                ->on('sizes')
                ->onDelete('set null')
                ->cascadeOnUpdate();
            $table->string('color')->nullable()->after('size_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            //
        });
    }
};
