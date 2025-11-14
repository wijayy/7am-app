<?php

use App\Models\Card;
use App\Models\Type;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Type::class)->constrained();
            $table->foreignIdFor(Card::class)->constrained();
            $table->string('name');
            $table->string('code');
            $table->string('phone');
            $table->string('email');
            $table->string('birthday');
            $table->string('slug');
            $table->integer('total_point')->default(0);
            $table->integer('active_point')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
