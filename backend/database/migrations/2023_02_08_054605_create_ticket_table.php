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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->enum('status', ['new', 'progress', 'closed']);
            $table->foreignId('report_id');
            $table->foreignId('admin_id')->nullable();
            $table->foreignId('ticket_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['report_id']);
            $table->dropForeign(['admin_id']);
            $table->dropForeign(['ticket_id']);
        });        
        Schema::dropIfExists('tickets');
    }
};
