@if(isset($data))
    @foreach($data as $reserve)
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th class="text-center normal-case">date</th>
                    <th class="text-center normal-case">day</th>
                    <th class="text-center normal-case">member</th>
                    <th class="text-center normal-case">cansel</th>
                </tr>
            </thead>
    
            <tbody>
    
                <form method="POST" }}">
                    @csrf
                    <input type="hidden" name="start_date" value="{{ $reserve->id}}">
                    
                    <tr>
                        <td class="text-center">{{ $reserve->start_date}}</td>
                        <td class="text-center">{{ $reserve->weekday }}</td>
                        <td class="text-center">
                        <td class="text-center">
                            <p>name</p>
                        </td>
                        <td class="text-center">
                            <div class="my-2">
                                <button type="submit" class="btn btn-outline btn-info btn-custom">この日の予定をキャンセル</button>
                                <button type="submit" class="btn btn-outline btn-info btn-custom">これ以降の予定もキャンセル</button>
                            </div>
                        </td>
                        
                    </tr>
                </form>
            </tbody>
        </table>
    @endforeach
@endif
        
</div>