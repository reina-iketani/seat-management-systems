

@extends('layouts.app')

@section('content')

@include('reserves.navtabs')

<?php 
use Carbon\Carbon;
$cb = Carbon::now();
?>

<div class="my-2">
        <p>毎週予約</p>
        <form method="POST" action="{{ route('reserves.store') }}">
            @csrf
                <input type="hidden" name="start_date" value="{{ $cb->format('Y-m-d') }}">
                <button type="submit" name="weekday" value="Mon" class="btn btn-outline btn-info btn-custom">Mon</button>
                <button type="submit" name="weekday" value="Tue" class="btn btn-outline btn-info btn-custom">Tue</button>
                <button type="submit" name="weekday" value="Wed" class="btn btn-outline btn-info btn-custom">Wed</button>
                <button type="submit" name="weekday" value="Thu" class="btn btn-outline btn-info btn-custom">Thu</button>
                <button type="submit" name="weekday" value="Fri" class="btn btn-outline btn-info btn-custom">Fri</button>
        </form>
    </div>
    <div class="my-2">
        <p>複数日程予約</p>
    </div>


<div class="m-15">   
    <table class="table table-zebra w-full ">
        <thead>
            <tr>
                <th class="text-center normal-case">check</th>
                <th class="text-center normal-case">date</th>
                <th class="text-center normal-case">day</th>
                <th class="text-center normal-case">status</th>
                <th class="text-center normal-case">menber</th>
            </tr>
        </thead>

        <tbody>
            
@for($d = $cb->copy(); $d< $cb->copy()->addMonth(1); $d->addDay(1))
@php
    $targetDate = $d->toDateString(); // 表示したい日付を指定
    $list =  \App\Models\Reserve::search($targetDate);  // searchメソッドを呼び出して予約情報を取得
    $isReserved = false;
@endphp

            
            <form method="POST"  action="{{ route('reserves.bulk.store') }}" >
                @csrf
                <tr　>
                    <td class="text-center">
                        @if($list->count()<8)
                            <input type="checkbox" name="start_date[]" value="{{ $d->toDateString() }}">
                        @endif
                    </td>
                    <td class="text-center">{{ $d->format('m月d日') }}</td>
                    <td class="text-center">{{ $d->format('D') }}</td>
                    <td class="text-center">
                        
                        @foreach($list as $reservation)
                            @if (in_array($user->name, explode(',', $reservation->user->name)))
                                予約済み
                                @php
                                    $isReserved = true; // 予約フラグをtrueに設定
                                @endphp
                                @break
                            @endif
                        @endforeach
                        @if(!$isReserved)
                            @if($list->count()>=8)
                            満席
                            @else
                            残{{8 - $list->count()}}
                            @endif
                        @endif
                    </td>
                    <td class="text-center">
                        @foreach($list as $reservation)
                            {{ $reservation->user->name }}   
                         @endforeach
                    </td>
                </tr>
@endfor
            </tbody>
        </table>

                <div class="m-4">
                    <button type="submit"  class="btn btn-outline btn-info btn-custom  w-full">選択した日を一括予約</button>
                </div>

            </form>



    

@endsection

