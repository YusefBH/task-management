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
        Schema::create('label_assigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('label_id');
            $table->morphs('foreign');
            $table->timestamps();

            $table->foreign('label_id')
                ->references('id')
                ->on('labels')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('label_assigns');
    }
};
