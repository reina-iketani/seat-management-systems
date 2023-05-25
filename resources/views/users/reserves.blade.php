@extends('layouts.app')

@section('content')
@include('reserves.navtabs')

@if(session('message'))
    <div class="alert alert alert-info mb-2">
        {{ session('message') }}
    </div>
@endif

<div class="m-15">   
    <table class="table table-zebra w-full ">
        <thead>
            <tr>
                <th class="text-center normal-case">date</th>
                <th class="text-center normal-case">day</th>
                <th class="text-center normal-case">cansel</th>
                <th class="text-center normal-case">cansel</th>
            </tr>
        </thead>

        <tbody>
<?php 
use Carbon\Carbon;
$cb = Carbon::now();


?>



@for($d = $cb->copy(); $d< $cb->copy()->addMonth(1); $d->addDay(1))
@php
    $targetDate = $d->toDateString(); // 表示したい日付を指定
    $list =  \App\Models\Reserve::search($targetDate);  // searchメソッドを呼び出して予約情報を取得
@endphp
    @foreach($list as $reservation)
        @if (in_array($user->name, explode(',', $reservation->user->name)))
            @php
                $shouldDisplay = true; // 表示するかどうかのフラグを初期化
            @endphp
        
            @foreach($reservation->cancels as $cancel)
                @php
                    $cancel_date = $cancel->cancel_date;
                    if ($cancel_date === $targetDate) {
                        $shouldDisplay = false;
                        break; // 一致した場合はループを終了
                    }
                @endphp
                
            @endforeach
            
            @if($shouldDisplay)
                <tr>
                        <td class="text-center">{{ $d->format('m月d日') }}</td>
                        <td class="text-center">{{ $d->format('D') }}</td>
            
                    <td class="text-center">
                        <div class="my-2">
                                @if($reservation->end_date == null)
                                    <form method="POST" action="{{ route('reserves.cancel' , ['reserve_id' => $reservation->id])}}">
                                        @csrf
                                            <input type="hidden" name="cancel_date" value="{{ $d->toDateString()}}">
                                        <button type="submit" class="btn btn-outline btn-info btn-custom" onclick="return confirm('{{ $d->format('m月d日') }} の予約をキャンセルします。よろしいですか？')">この日の予約をキャンセル</button>
                                    </form>
                                @endif
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="my-2">
                                <form method="POST" action="{{ route('reserves.destroy', $reservation->id) }}">
                                    @csrf
                                    @method('DELETE')
                                        
                                        <button type="submit" class="btn btn-outline btn-info btn-custom" onclick="return confirm('{{ $d->format('m月d日') }}と毎週{{ $d->format('D') }} の予約をキャンセルします。よろしいですか？')">この日と繰り返し予約のキャンセル</button>
                                </form>
                        </div>
                    </td>
                </tr>
            @endif
            
        @endif
        
    @endforeach  
@endfor



        </tbody>
    </table>
</div>
@endsection