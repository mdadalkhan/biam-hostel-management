<?php
/**
 * @author <mdadalkhan@gmail.com>
 * @created_at: 18/02/2026
 * @updated_at: 18/02/2026
 * */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->string('room_no');
            $table->string('seat_no');
            $table->enum('type', ['ac', 'non_ac']);
            $table->decimal('rent', 10, 2);
            $table->string('building_no');
            $table->enum('status', ['booked', 'available', 'unavailable'])->default('available');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->unique(['room_no', 'seat_no']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
