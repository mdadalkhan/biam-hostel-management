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
            $table->foreignId('room_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->string('seat_no');
            $table->enum('type', ['ac', 'normal','vip']);
            $table->decimal('rent', 10, 2);
            $table->enum('status', ['booked', 'available', 'unavailable'])->default('available');
            $table->timestamps();

            $table->unique(['room_id', 'seat_no']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
