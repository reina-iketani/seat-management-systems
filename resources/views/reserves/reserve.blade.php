@php
use Carbon\Carbon;
$cb = Carbon::now();
@endphp
@if(session('message'))
    <div class="alert alert-info mb-2">
        {{ session('message') }}
    </div>
@endif
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
<div class="m-15">
    <p>日別予約</p>
    <table class="table table-zebra w-full ">
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
@for($d = $cb->copy(); $d< $cb->copy()->addMonth(1); $d->addDay(1))
@if ($d->isWeekday())
@php
    $targetDate = $d->toDateString(); // 表示したい日付を指定
    $list =  \App\Models\Reserve::search($targetDate);  // searchメソッドを呼び出して予約情報を取得
    $isReserved = false;
    $canceledUsers = \App\Models\Cancel::where('cancel_date', $targetDate)
    ->join('reserves', 'cancels.reserve_id', '=', 'reserves.id')
    ->join('users', 'reserves.user_id', '=', 'users.id')
    ->pluck('users.name')
    ->toArray();
@endphp
                <tr>
                    <td class="text-center">{{ $d->format('m月d日') }}</td>
                    <td class="text-center">{{ $d->format('D') }}</td>
                    <td class="text-center">
                        @php
                            $username = array_unique($list->pluck('user.name')->toArray());
                            $count = count($username);
                        @endphp
                        @foreach($list as $reservation)
                            @if(in_array($reservation->user->name, $canceledUsers))
                            @elseif(in_array($user->name, explode(',', $reservation->user->name)))
                                <p class="badge badge-warning">予約済み</p>
                                @php
                                    $isReserved = true; // 予約フラグをtrueに設定
                                @endphp
                                @break
                            @endif
                        @endforeach
                        @if(!$isReserved)
                            @if($count>=8)
                            <p class="badge badge-error">満席</p>
                            @else
                            <p class="badge badge-outline">残{{8 - $count + count($canceledUsers)}}</p>
                            @endif
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="flex justify-center">
                        @foreach($username as $index => $users)
                            @if(in_array($users, $canceledUsers))
                            @else
                                <p class="p-3">{{$users}}さん</p>
                                @if(($index + 1) % 4 == 0 && $index < count($username) - 1)
                                    </div><div class="flex justify-center">
                                @endif
                            @endif
                        @endforeach
                        </div>
                    </td>
                    <td class="text-center"><div class="my-2">
                        @if ($list->count() - count($canceledUsers) < 8)
                            @php
                                $isUserReserved = false;
                            @endphp
                            @foreach ($list as $reservation)
                                @if(in_array($user->name, $canceledUsers))
                                    @php
                                        $isUserReserved = false;
                                        break;
                                    @endphp
                                @elseif($reservation->user_id == $user->id)
                                    @php
                                        $isUserReserved = true;
                                        break;
                                    @endphp
                                @endif
                            @endforeach
                                @if (!$isUserReserved)
                                    @if (!in_array($user->name, $canceledUsers))
                                       <form method="POST" action="{{ route('reserves.store') }}">
                                            @csrf
                                            <input type="hidden" name="start_date" value="{{ $d->toDateString()}}">
                                            <input type="hidden" name="end_date" value="{{ $d->toDateString() }}">
                                            <input type="hidden" name="weekday" value="{{ $d->format('D') }}">
                                            <button type="submit" class="btn btn-outline btn-info btn-custom">予約</button>
                                        </form>
                                    @else
                                        @foreach($list as $reservation)
                                            @foreach($reservation->cancels as $cancel)
                                                @if($cancel->cancel_date == $d->toDateString())
                                                    <form method="POST" action="{{ route('cancels.destroy', $cancel->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline btn-info btn-custom">キャンセル解除</button>
                                                    </form>
                                                @endif
                                            @endforeach
                                         @endforeach
                                    @endif
                                 @endif
                        @endif
                    </td>
                </tr>
@endif
@endfor
        </tbody>
    </table>
</div>