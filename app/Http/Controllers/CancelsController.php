<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Reserve;
use App\Models\Cancel;

class CancelsController extends Controller
{
    
    
    public function store(Request $request){
        $reserveId = $request->reserve_id; // 予約情報のIDを取得
    
        $reserve = Reserve::findOrFail($reserveId); // 予約オブジェクトを取得
        
        $reserve->cancels()->create([
            'cancel_date' => $request->cancel_date,]);
            
        session()->flash('message', '予約をキャンセルしました。');
        
        // 前のURLへリダイレクトさせる
        return back();
    }
    
    
    public function destroy($id){
        $cancel = Cancel::findOrFail($id);
        
        $cancel->delete();
        session()->flash('message', '予約キャンセルを解除しました。');
        
        return back();
    }
    
    
}
