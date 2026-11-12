<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fashion_products', function (Blueprint $table) {
            $table->unsignedInteger('marked_price')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('description_html')->nullable();
            $table->foreignId('subcategory_id')->nullable()->constrained('fashion_categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('fashion_products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('subcategory_id');
            $table->dropColumn(['marked_price', 'meta_description', 'description_html']);
        });
    }
};
