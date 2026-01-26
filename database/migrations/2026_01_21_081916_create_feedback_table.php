<?php
/**
 * @author <mdadalkhan@gmail.com>
 * Date: 21/01/2026
 * */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();

            $table->string('room_number');
            $table->string('phone')->nullable();
            $table->string('name')->nullable();
            $table->string('designation')->nullable();
            $table->unsignedTinyInteger('rating_front_desk_service');
            $table->unsignedTinyInteger('rating_canteen_food');
            $table->unsignedTinyInteger('rating_canteen_staff_service');
            $table->unsignedTinyInteger('rating_room_boys_service');
            $table->unsignedTinyInteger('rating_cleanliness_of_room');
            $table->unsignedTinyInteger('rating_overall_cleanliness_around_room');
            $table->unsignedTinyInteger('rating_washroom_ac_lights_fan');
            $table->unsignedTinyInteger('satisfaction_level');
            $table->enum('sms_status', ['sent', 'pending'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
