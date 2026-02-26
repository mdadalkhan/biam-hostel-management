<?php
/**
 * @author <mdadalkhan@gmail.com>
 * @created_at: 25/02/2026
 * @updated_at: 25/02/2026
 * */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_no',
        'building_no'
    ];

    public function seats(): HasMany {
        return $this->hasMany(Seat::class,'room_id','id');
    }
}

