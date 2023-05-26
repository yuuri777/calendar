@extends('layouts.callayout')
@section('content')


<!-- カレンダー部分 -->
<div class="d-flex">
  <div style="width:50%;">
    <h1>{{ $year }}年{{ $month }}月 {{ $id }}日</h1>
      <table style="width: 90%; height: 500px;">
        <a class="ml-3 btn create" href="{{route('cal.create')}}">イベントを追加</a>
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
              <td class="calendar " @if ($i == $today) id="today"  @endif>
                <a href="{{ route('cal.detail',['id' => $i]) }}" class="" >{{ $i }}</a>
              </td>
              @if ($i == $daysInMonth || $i % 7 == 0)
              </tr>
              @endif
            @endfor
          </tbody>
      </table>
    </div>
    
    
    <!-- 右側の時間ごとの詳細部分 -->
    <div class="detail">
      <h1>{{ $id }}</h1> 
        <div class="border-end bg-white" id="sidebar-wrapper" >
          <div class="list-group list-group-flush"  >
          <!-- 時間詳細の繰り返し文 -->
          
          
          <table >
          @for ($i = 1; $i <= 24; $i++)
            <tr >
              <th style="width: 40px;">{{$i}}</th>
                @if($events)
                  @foreach($events as $event)
                    @if($event->timeid == $i)
                      <td ><a href="{{ route('cal.edit',['id' => $event->id] ) }}">{{$event ->title}}</a>  <br>   {{$event->cal_status_string}}</td>
                    @endif
                  @endforeach
                @endif
            </tr>
          @endfor
          </table>
          </div>
    </div> 
</div>

@endsection 