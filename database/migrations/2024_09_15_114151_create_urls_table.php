<?php

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
        Schema::create('urls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('original_url');
            $table->string('shortened_alias')->unique();
            $table->tinyInteger('is_private')->comment('0=No, 1=Yes')->default(0);
            $table->dateTime('expired_at')->nullable();
            $table->tinyInteger('is_active')->comment('0=No, 1=Yes')->default(1);
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urls');
    }
};
