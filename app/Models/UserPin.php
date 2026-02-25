<?php

/**
 * @author <mdadalkhan@gmail.com>
 * @created_at: 23/02/2026
 * @updated_at: 23/02/2026
 * */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\User;

class UserPin extends Model {
    protected $table    = 'users_pins';
    protected $fillable = ['user_id', 'pin', 'status'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
