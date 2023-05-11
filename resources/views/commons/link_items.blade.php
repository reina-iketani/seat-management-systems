@if (Auth::check())
    {{-- 予定へのリンク --}}
    <li><a class="link link-hover" href="#">予定</a></li>
    <li class="divider lg:hidden"></li>
    {{-- 一括予約へのリンク --}}
    <li><a class="link link-hover" href="#">一括予約</a></li>
    <li class="divider lg:hidden"></li>
    {{-- 予約一覧へのリンク --}}
    <li><a class="link link-hover" href="#">予約一覧</a></li>
    <li class="divider lg:hidden"></li>
    @can('admin-higher')　{{-- 管理者に表示される --}}
        {{-- 出社指示へのリンク --}}
        <li><a class="link link-hover" href="#">出社指示</a></li>
        <li class="divider lg:hidden"></li>
        {{-- 出社取り下げへのリンク --}}
        <li><a class="link link-hover" href="#">出社取り下げ</a></li>
        <li class="divider lg:hidden"></li>
    @endcan
    {{-- ログアウトへのリンク --}}
    <li><a class="link link-hover" href="#" onclick="event.preventDefault();this.closest('form').submit();">Logout</a></li>
@else
    {{-- ユーザ登録ページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('register') }}">Signup</a></li>
    <li class="divider lg:hidden"></li>
    {{-- ログインページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('login') }}">Login</a></li>
@endif