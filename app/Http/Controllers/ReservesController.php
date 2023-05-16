<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reserve;

use App\Services\CalendarService;


class ReservesController extends Controller
{
    public function search($targetDate)
    {
        $list = Reserve::search($targetDate);
        
        // その他の処理やビューの表示など
        
        return view('dashboard', ['list' => $list]);
    }
    
    
   
    public function index(){
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            
            $user = \Auth::user();
            
            $reserves = $user->reserves;
            $data = [
                'user' => $user,
                'reserves' => $reserves,
            ];
             
        }
        
         
        
        // dashboardビューでそれらを表示
        return view('dashboard', $data);
    
    }
    
    
    
    
    public function store(Request $request)
    {
        
        
        
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->reserves()->create([
            'weekday' => $request->weekday,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        
        
        
        // 前のURLへリダイレクトさせる
        return back();
    }
    
    
    public function countReservesByWeekday()
    {
        
        $reserves = Reserve::countReservesByWeekday();
        
        return view('reserves.reserve', ['reserves' => $reserves]);
    }
    
    
    public function show($id){
        $reservation = Reserve::findOrFail($id); // IDに基づいて予約を取得
        dd($id);
        if (\Auth::check()) { // 認証済みの場合
            $weekday = $reservation->weekday;
            $start_date = $reservation->start_date;
            $end_date = $reservation->end_date;
            return view('reserves.myreserving', [
                'reservation' => $reservation,
                'weekday' => $weekday,
                'start_date' => $start_date,
                'end_date' => $end_date,
                ]);
        }
    }
    
    
}