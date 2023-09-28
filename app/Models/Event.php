<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'timestamp'];

    public function scopeWithinDateRange($query, $start, $end)
    {
        return $query->where('timestamp', '>=', $start)
                    ->where('timestamp', '<=', $end);
    }
    
}
