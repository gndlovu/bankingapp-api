<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transaction_type_id')->unsigned();
            $table->bigInteger('account_id')->unsigned();
            $table->bigInteger('to_account_id')->unsigned()->nullable();
            $table->bigInteger('to_branch_id')->unsigned()->nullable();
            $table->string('account_holder', 60)->nullable();
            $table->string('account_no', 11)->nullable();
            $table->string('my_reference', 60)->nullable();
            $table->string('thier_reference', 60)->nullable();
            $table->decimal('amount')->nullable();
            $table->datetime('created_at')->default(now());
            $table->foreign('transaction_type_id')->references('id')->on('transaction_types')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('to_account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('to_branch_id')->references('id')->on('branches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
