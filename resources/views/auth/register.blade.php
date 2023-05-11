@extends('layouts.app')

@section('content')

    <div class="prose mx-auto text-center">
        <h2>Sign up</h2>
    </div>

    <div class="flex justify-center">
        <form method="POST" action="{{ route('register') }}" class="w-1/2">
            @csrf

            <div class="form-control my-4">
                <label for="name" class="label">
                    <span class="label-text">Name</span>
                </label>
                <input type="text" name="name" class="input input-bordered w-full">
            </div>

            <div class="form-control my-4">
                <label for="email" class="label">
                    <span class="label-text">Email</span>
                </label>
                <input type="email" name="email" class="input input-bordered w-full">
            </div>
            
            <!-- role -->
            <div>role</div>
            <div class="flex gap-2 mb-4">
                <div class="form-control items-center">
                    <label for="role" class="label cursor-pointer">
                        <input type="radio" name="role" id="role" value="1" class="radio" >
                        <span class="label-text">部長以上</span>
                    </label>
                </div>
                <div class="form-control items-center">
                    <label for="e" class="label cursor-pointer">
                        <input type="radio" name="role" id="role" value="11" class="radio" checked>
                        <span class="label-text">その他</span>
                    </label>
                </div>
            </div>

            <div class="form-control my-4">
                <label for="password" class="label">
                    <span class="label-text">Password</span>
                </label>
                <input type="password" name="password" class="input input-bordered w-full">
            </div>

            <div class="form-control my-4">
                <label for="password_confirmation" class="label">
                    <span class="label-text">Confirmation</span>
                </label>
                <input type="password" name="password_confirmation" class="input input-bordered w-full">
            </div>

            <button type="submit" class="btn btn-primary btn-block normal-case">Sign up</button>
        </form>
    </div>
@endsection