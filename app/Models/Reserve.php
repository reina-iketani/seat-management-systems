<?php

namespace App\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Reserve extends Model
{
    use HasFactory;
    protected $fillable = ['weekday','start_date','end_date',];
    
    
    
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public static function search($targetDate){
        $weekday = Carbon::parse($targetDate)->format('D');
    
        $list = Reserve::with(['user', 'cancels'])
            ->where('start_date', '<=', $targetDate)
            ->where(function ($query) use ($targetDate, $weekday) {
                $query->where('end_date', '>=', $targetDate)
                    ->orWhereNull('end_date');
            })
            ->where('weekday', $weekday)
            ->get();
    
        return $list;
    }
    
    
    public function cancels()
    {
        return $this->hasMany(Cancel::class);
    }
    
    
    
    
}