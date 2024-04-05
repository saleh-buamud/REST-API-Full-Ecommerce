<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigend();
            $table->bigInteger('brand_id')->unsigend();
            $table->string('name');
            $table->boolean('is_trendy')->default(false);
            $table->boolean('is_available')->default(true);
            $table->double('price', 8, 2);
            $table->integer('amount');
            $table->double('discount', 8, 2)->nullable();
            $table->string('image');
            $table->forginId('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->forginId('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
