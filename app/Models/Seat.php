<?php
/**
 * @author <mdadalkhan@gmail.com>
 * @created_at: 25/02/2026
 * @updated_at: 25/02/2026
 * */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seat extends Model 
{
    use HasFactory;

    protected $table = 'seats';

    protected $fillable = [
        'room_id',
        'seat_no',
        'type',
        'rent',
        'building_no',
        'status',
    ];

    protected $casts = [
        'rent' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function room(): BelongsTo 
    {
        return $this->belongsTo(Room::class);
    }
}