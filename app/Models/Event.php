<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DateTimeZone;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'timestamp'];

    public function scopeInDateRange($query, $startDate, $endDate, $clientTimezone)
    {
        $startDate = Carbon::parse($startDate, new DateTimeZone($clientTimezone))->endOfDay();
        $endDate = Carbon::parse($endDate, new DateTimeZone($clientTimezone))->endOfDay();

        return $query->whereBetween('timestamp', [$startDate, $endDate]);
    }
    
}
