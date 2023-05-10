@extends('layouts.callayout')
@section('content')



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
    <div class="detail">
      <h1>{{ $id }}</h1> 
  <!-- <h1>  {  { $date }}</h1> -->
     
      
 <div class="border-end bg-white" id="sidebar-wrapper" >
    </div>
    <div class="list-group list-group-flush" >
        @for ($i = 1; $i <= 24; $i++)

        <table>
  <tr>
  <th >{{$i}}</th>
  @foreach ($events as $event)
  <td></td>
    @endforeach
    
  </tr>
  
</table>

@endfor

      </div>
</div>

        

 @endsection 