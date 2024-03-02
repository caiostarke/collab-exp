<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'user_id',
        'opportunity_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function opportunity() {
        return $this->belongsTo(Opportunities::class);
    }
}
