<?php

use App\Models\District;
use App\Models\Regency;
use App\Models\User;
use App\Models\Village;
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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->text('address');
            $table->string('name');
            $table->string('phone');
            $table->foreignIdFor(Regency::class)->constrained();
            $table->foreignIdFor(District::class)->constrained();
            $table->foreignIdFor(Village::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};