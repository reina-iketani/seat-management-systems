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
       
        $weekday = Carbon::parse($targetDate)->format('D'); // 指定日から曜日を求める
        $list = Reserve::query()
            ->where('start_date', '<=', $targetDate)
            ->where('end_date', '>=', $targetDate)
            ->where('weekday', $weekday)
            ->get(); // startDate<=targetDate && endDate>=targetDate && weekday=weekday のレコードを抽出
        
        return $list;
    }
}