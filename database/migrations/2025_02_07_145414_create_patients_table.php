<?php

use App\Enums\GranderEnums;
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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('another_name')->nullable();
            $table->string("personal_id");
            $table->string("personal_image")->nullable();
            $table->string("first_phone");
            $table->string("second_phone")->nullable();
            $table->tinyInteger("status")->default(1);
            $table->text("description")->nullable();
            $table->string("grander")->default(GranderEnums::Male->value);  
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
