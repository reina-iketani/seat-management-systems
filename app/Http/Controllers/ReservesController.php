<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reserve;

use App\Services\CalendarService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ReservesController extends Controller
{
    public function search($targetDate)
    {
        $list = Reserve::search($targetDate);
        
        // その他の処理やビューの表示など
        
        return view('dashboard', ['list' => $list]);
    }
    
    
   
    public function index(Request $request){
        $data = [];
        
        
       if (\Auth::check()) { // 認証済みの場合
            
            $user = \Auth::user();
            
            
            $reserves = $user->reserves()->with('cancels')->get();
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
       /* try {
            DB::beginTransaction();*/
            
            
            
            
            $count = Reserve::where('end_date', $request->end_date)->count();

            if(!is_null($request->end_date) === null && $count >= 8){
                session()->flash('message', '予約が失敗しました。直前に満席になった可能性がございます。恐れ入りますがもう一度お願いいたします。');
            }else{
            
        
                if ($request->end_date === null) {
                    
                    session()->flash('message', '予約が完了しました。');
                    
                    $existingReservation = Reserve::where('weekday', $request->weekday)
                    ->where('user_id', $request->user()->id)
                    ->first();
                    
                    if ($existingReservation) {
                        $existingReservation->delete();
                        session()->flash('message', '予約を更新しました。');
                    }
                    
                }else{
                    session()->flash('message', '予約が完了しました。');
                }
                    
            
                    // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
                    $reservation =$request->user()->reserves()->create([
                        'weekday' => $request->weekday,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                    ]);
                    
                    
                    
                    $date = $reservation->start_date;
                    $weekday = $reservation->weekday;
                
                    $list = Reserve::search($date);
                    $count = $list->where('weekday', $weekday)->count();
                
                    
                    if ($count >= 8){
                            $this->createCancel($reservation->id, $request->start_date);
                    }
                    
            }
                
                // 前のURLへリダイレクトさせる
                return back();
                
              /*   DB::commit();
            } catch (Throwable $e) {
                 DB::rollBack();
            }*/
        
    }
    
    
    
    
    private function createCancel($reserveId, $cancelDate)
    {
        $reserve = Reserve::findOrFail($reserveId);
        
        $reserve->cancels()->create([
            'cancel_date' => $cancelDate,
        ]);
        
        $cancelDate = Carbon::parse($cancelDate);
        session()->flash('message', '' . $cancelDate->format('D') . 'の毎週予約を完了しました。"' . $cancelDate->format('m月d日') . '"は満席の為、' . $cancelDate->format('m月d日') . 'のみキャンセルさせていただきました。空き枠が出ましたら、メインページキャンセル解除ボタンより予約可能です。');
    }

    
    public function countReservesByWeekday()
    {
        
        $reserves = Reserve::countReservesByWeekday();
        
        return view('reserves.reserve', ['reserves' => $reserves]);
    }
    
    
    public function destroy($id){
        $reservation = Reserve::findOrFail($id);
        // 予約の削除処理
        $reservation->delete();
        
        session()->flash('message', '予約をキャンセルしました。');
        
        return back();
    }
    
    
    
    
    
    public function reservedelete()
    {
        $expirationDate = Carbon::now()->subDays(5)->format('Y-m-d');

        Reserve::where('end_date', '<', $expirationDate)->delete();
    }
    
  
    
    
    
}