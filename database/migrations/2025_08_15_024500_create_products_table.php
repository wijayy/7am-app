<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            // $table->string('slug')->unique();
            $table->foreignIdFor(Category::class)->constrained();
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->text('description');
            $table->integer('price');
            $table->integer('moq');
            $table->enum('freshness', ['fresh', 'frozen'])->default('fresh');
            $table->enum('status', ['active', 'inactive'])->default('active');
            // $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
