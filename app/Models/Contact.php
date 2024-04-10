<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->formatLocalized('%d %B %Y, %H:%M');
    }
}
