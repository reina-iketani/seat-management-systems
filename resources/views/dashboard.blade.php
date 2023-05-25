
@extends('layouts.app')

@section('content')
    @if (Auth::check())
        
            <div class="sm:col-span-2 mt-4">
                @include('reserves.navtabs')  
            
                
                {{-- 投稿一覧 --}}
                @include('reserves.reserve')
            </div>
        </div>
    @else
        <div class="prose hero bg-base-200 mx-auto max-w-full rounded">
            <div class="hero-content text-center my-10">
                <div class="max-w-md mb-10">
                    <h2>Welcome to the</h2>
                    <h2>Seat Management Systems</h2>
                    {{-- ユーザ登録ページへのリンク --}}
                    <a class="btn btn-primary btn-lg normal-case" href="{{ route('register') }}">Sign up now!</a>
                </div>
            </div>
        </div>
    @endif

@endsection