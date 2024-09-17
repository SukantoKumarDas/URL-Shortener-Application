<?php

use App\Models\Admin;
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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('role')->comment('1 = Master admin, 2 = General user');
            $table->rememberToken();
            $table->timestamps();
        });

        $admin = new Admin();
        $admin->name = 'admin';
        $admin->email = 'admin@example.com';
        $admin->email_verified_at = now();
        $admin->password = bcrypt('admin1234');
        $admin->role = 1; // master admin
        $admin->remember_token = Str::random(10);
        $admin->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
