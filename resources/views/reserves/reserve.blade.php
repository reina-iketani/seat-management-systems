<div>
        <p mt-10>通知メッセージ</p>
    </div>
    
    <table class="table table-zebra w-full">
        <thead>
            <tr>
                <th class="text-center normal-case">date</th>
                <th class="text-center normal-case">day</th>
                <th class="text-center normal-case">status</th>
                <th class="text-center normal-case">member</th>
                <th class="text-center normal-case">reserve</th>
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
            <form method="POST" action="{{ route('reserves.store') }}">
                @csrf
                <input type="hidden" name="start_date" value="{{ $d->toDateString()}}">
                <input type="hidden" name="end_date" value="{{ $d->toDateString() }}">
                <input type="hidden" name="weekday" value="{{ $d->format('D') }}">
                <tr　>
                    <td class="text-center">{{ $d->format('m月d日') }}</td>
                    <td class="text-center">{{ $d->format('D') }}</td>
                    <td class="text-center">
                        
                        @if($list->count()>=8)
                            満席
                        @else
                            残{{8 - $list->count()}}
                        @endif
                    </td>
                    <td class="text-center">
                        @foreach($list as $reservation)
                            {{ $reservation->user->name }}   
                        @endforeach
                            
                    </td>
                    <td class="text-center"><div class="my-2">
                        @if($list->count() < 8)
                            <button type="submit" class="btn btn-outline btn-info btn-custom">予約</button></div>
                        @endif
                        </td>
                        
                </tr>
            </form>
@endfor
        </tbody>
    </table>
</div>