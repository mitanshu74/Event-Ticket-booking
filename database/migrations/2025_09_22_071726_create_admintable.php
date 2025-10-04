<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            // ✅ Role (1 = Admin, 2 = Subadmin)
            $table->unsignedTinyInteger('role')->default(1)
                ->comment('1 = Admin, 2 = Subadmin');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admintable');
    }
};
