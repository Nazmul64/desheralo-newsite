<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companyinfos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('location_map')->nullable();
            $table->text('message')->nullable();
            $table->text('copyright')->nullable();
            $table->string('version')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companyinfos');
    }
};
