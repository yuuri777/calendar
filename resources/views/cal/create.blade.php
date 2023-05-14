@extends('layouts.callayout')
@section('content')

<div class="d-flex">
    <div style="width:50%;">
    <h1>{{ $year }}年{{ $month }}月のカレンダー</h1>
    <table style="width: 90%; height: 500px;">
    <a class="ml-3 btn create"  href="{{route('cal.create')}}">イベントを追加</a>

        <thead>
            <tr>
                <th>日</th>
                <th>月</th>
                <th>火</th>
                <th>水</th>
                <th>木</th>
                <th>金</th>
                <th>土</th>
            </tr>
        </thead>
        <tbody>
     @php
     $today = date("j");
     @endphp
        <!--  jはdate関数のフォーマット指定子の一つで、日を表す文字列を返す。 -->
             @for ($i = 1; $i <=  $daysInMonth; $i++) 
                @if ($i == 1 || $i % 7 == 1)<!--$iが1に等しいか、7で割った数字の余りが1に等しいかというif文 -->
                    <tr>
                @endif
                <td class="calendar" @if ($i == $today) id="today"  @endif>

                    <a href="{{ route('cal.detail',['id' => $i]) }}" class="" >{{ $i }}</a>
</td>
                    @if ($i == $daysInMonth || $i % 7 == 0)
                    </tr>
                @endif
            @endfor
        </tbody>
    </table>

 </div>
    <div style="width:80%; margin-top: 30px">
    <div class="container" >
        <div class="row justify-content-center" >
            <div class="col-md-8">
                <div class="card" >
                    <div class="card-header">経済指標入力</div>

                    <div class="card-body">
                        <form method="POST" action=" {{ route('cal.store' )}}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">イベント名</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="title" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                    
                                <label for="value" class="col-md-4 col-form-label text-md-right">重要度</label>

                                <div class="col-md-6">
                                <select name="importance" id="task_status" class="form-select @error('task_status')is-invalid @enderror">

                                    @foreach($calstatuses as $key => $calstatus)
                                    <option  value="{{ $key }}">{{ $calstatus }}</option>
                                    @endforeach
                                </select>
                                
                                    @error('value')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            

                            <div class="form-group row" style="margin-top: 30px">
                            <label for="date" class="col-md-4 col-form-label text-md-right">イベント日時</label>

                                <div class="col-md-6">
                                    <input id="date" type="datetime-local" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required autocomplete="date">

                                    @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0" style="margin-top: 30px">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn create">
                                        保存
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
</div>  
@endsection