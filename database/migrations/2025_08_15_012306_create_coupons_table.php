<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('slug')->unique();
            $table->enum('type', ['fixed', 'percentage']);
            $table->integer('amount');
            $table->integer('limit')->nullable();
            $table->integer('minimum')->default(0);
            $table->integer('maximum')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
