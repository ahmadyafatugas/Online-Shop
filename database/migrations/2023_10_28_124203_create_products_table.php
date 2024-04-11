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
            $table->text("title");
            $table->text("description");
            $table->text("url");
            $table->integer("price");
            $table->integer("stock");
            $table->unsignedBigInteger("category_id");
            $table->unsignedBigInteger("seller_id");
            $table->timestampsTz(6);

            $table->foreign("category_id")->references("id")->on("categories");
            $table->foreign("seller_id")->references("id")->on("sellers");
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
