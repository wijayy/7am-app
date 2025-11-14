<?php

use App\Models\Category;
use App\Models\SetCategory;
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
        Schema::create('set_category_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SetCategory::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(Category::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set_category_items');
    }
};
