<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameUserIdToProductIdInProductSizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_size', function (Blueprint $table) {
            //
            // 1) ลบ FK เดิม user_id
            $table->dropForeign(['user_id']);

            // 2) ลบ column user_id
            $table->dropColumn('user_id');

            // 3) เพิ่ม column product_id และกำหนด foreign key ใหม่
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_size', function (Blueprint $table) {
            //
            // กลับด้านเมื่อ rollback

            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        });
    }
}
