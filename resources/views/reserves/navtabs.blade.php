<div class="tabs">
    <a href="{{ route('dashboard') }}" class="tab tab-lifted grow {{ Request::routeIs('dashboard') ? 'tab-active' : '' }} ">
        <span>予定</span>
    </a>
    <a href="{{ route('users.reserves', ['id' => $user->id]) }}" class="tab tab-lifted grow {{ Request::routeIs('users.reserves') ? 'tab-active' : '' }}">
        <span>予約一覧</span>
    </a>
</div>
