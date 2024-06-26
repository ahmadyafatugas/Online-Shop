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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id");
            // $table->unsignedInteger("payment_id");
            $table->integer("total");
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users");
            // $table->foreign("payment_id")->references("id")->on("payments");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
