<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('transactions_to_branch_id_foreign');
            $table->dropColumn('to_branch_id');
            $table->dropColumn('account_holder');
            $table->dropColumn('account_no');
            $table->dropColumn('thier_reference');
            $table->renameColumn('my_reference', 'reference');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->bigInteger('to_branch_id')->unsigned()->nullable();
            $table->string('account_holder', 60)->nullable();
            $table->string('account_no', 11)->nullable();
            $table->string('thier_reference', 60)->nullable();
            $table->renameColumn('reference', 'my_reference');
            $table->foreign('to_branch_id')->references('id')->on('branches')->onDelete('cascade');
        });
    }
}
