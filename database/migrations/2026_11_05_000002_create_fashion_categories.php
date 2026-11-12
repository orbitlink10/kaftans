<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fashion_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 160);
            $table->string('slug', 180)->unique();
            $table->text('meta_description')->nullable();
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('fashion_categories')->nullOnDelete();
            $table->string('image')->nullable();
            $table->timestamps();
        });
        foreach (['dresses' => 'Dresses', 'tops' => 'Tops', 'bottoms' => 'Bottoms', 'matching-sets' => 'Matching Sets', 'outerwear' => 'Outerwear'] as $slug => $name) {
            DB::table('fashion_categories')->insert(['name' => $name, 'slug' => $slug, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('fashion_categories');
    }
};
