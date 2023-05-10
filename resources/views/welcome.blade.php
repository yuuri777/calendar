@extends('layouts.layout')

@section('title')
    タスク管理
@endsection

@section('content')
    <div class="top-page d-flex flex-column justify-content-center align-items-center ">
        <div class="h1 text-center">
            <h1 class="text-light">カレンダー</h1>
            <h2 class="text-light">いつでもどこでも簡単に♪</h2>
        </div>
        <div class="d-flex">
            @auth
                <a href="#" class="btn btn-success">プロジェクト一覧</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-success">まずは無料で登録する</a>
            @endauth
        </div>
    </div>
@endsection