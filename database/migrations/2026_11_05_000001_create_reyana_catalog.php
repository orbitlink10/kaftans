<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fashion_products', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('collection');
            $table->unsignedInteger('price'); // Whole KSh, never floating-point arithmetic.
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->text('care')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
        Schema::create('fashion_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fashion_product_id')->constrained()->cascadeOnDelete();
            $table->string('size');
            $table->string('color');
            $table->unsignedInteger('stock')->default(0);
            $table->unique(['fashion_product_id', 'size', 'color']);
        });
        Schema::create('fashion_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('consented_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fashion_subscribers');
        Schema::dropIfExists('fashion_variants');
        Schema::dropIfExists('fashion_products');
    }
};
