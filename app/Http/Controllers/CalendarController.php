<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCalRequest;
use App\Http\Requests\UpdateCalRequest;
use Carbon\Carbon;
use App\Models\Cal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CalendarController extends Controller
{
   

    public function index(Request $request)
    {
        
        //現在日時を取得
        $now = Carbon::now();
        // carbonに関して   https://qiita.com/kohboh/items/0e255dc3bba067bc447c
        
        // dd($request);
        //表示する現在の年月を取得
        $year = $request->input('year',$now->year);
    
        $month = $request->input('month',$now->month);
        $date = $request->input('date');
        
            
       
        //カレンダーを表示する日時を取得
        $daysInMonth = Carbon::createFromDate($year,$month)->daysInMonth;
        // Carbonライブラリを使用して、指定された年と月に対して、その月の日数を計算している。
        // $daysInMonth = Carbon::createFromDateのメソッドで指定された年と月のcarbonインスタンスを作成する。

        $startOfMonth = Carbon::createFromDate($year,$month)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year,$month)->endOfMonth();
        //カレンダーの表示に必要なデータを配列に格納
        $data = [
            "year" => $year,
            "month" => $month,
            "daysInMonth" => $daysInMonth,
            "startOfMonth" => $startOfMonth,
            "endOfMonth" => $endOfMonth,   ];
            //カレンダーのビューを表示
        // return view('cal.index',$data);
        return view('cal.index',$data);
    }
    public function detail(Request $request,$id)
    {
       
        $events = Cal::where('dateid',$id)->get();
        //矢印はオブジェクトプロパティやメソッドにアクセスするために使用される演算子。
        //$roles = $user->roles;の場合は$userオブジェクトのrolesプロパティにアクセスするということ。$roles変数に$userオブジェクトのrolesプロパティが代入される。


        //現在日時を取得
        $now = Carbon::now();
        
        //表示する年月を取得
        $year = $request->input('year',$now->year);
        $month = $request->input('month',$now->month);
    
        //カレンダーを表示する日時を取得
        $daysInMonth = Carbon::createFromDate($year,$month)->daysInMonth;
        // Carbonライブラリを使用して、指定された年と月に対して、その月の日数を計算している。
        // $daysInMonth = Carbon::createFromDateのメソッドで指定された年と月のcarbonインスタンスを作成する。
        $startOfMonth = Carbon::createFromDate($year,$month)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year,$month)->endOfMonth();
        // dd( $startOfMonth,$endOfMonth);
        //カレンダーの表示に必要なデータを配列に格納
        $data = [
            "year" => $year,
            "month" => $month,
            "daysInMonth" => $daysInMonth,
            "startOfMonth" => $startOfMonth,
            "endOfMonth" => $endOfMonth, 
            "id" => $id , 
            "events" =>$events,
            
            ];
            // dd($data);
        
            //カレンダーのビューを表示
        // return view('cal.index',$data);
        return view('cal.detail',$data);
    }
    public function create(Request $request)
    {
        $events = Cal::all();
         //現在日時を取得
         $now = Carbon::now();
         
         //表示する年月を取得
         $year = $request->input('year',$now->year);
         $month = $request->input('month',$now->month);
 
         //カレンダーを表示する日時を取得
         $daysInMonth = Carbon::createFromDate($year,$month)->daysInMonth;
         // Carbonライブラリを使用して、指定された年と月に対して、その月の日数を計算している。
         // $daysInMonth = Carbon::createFromDateのメソッドで指定された年と月のcarbonインスタンスを作成する。
 
         $startOfMonth = Carbon::createFromDate($year,$month)->startOfMonth();
         $endOfMonth = Carbon::createFromDate($year,$month)->endOfMonth();

         $calstatuses = Cal::CAL_STATUS_STRING;

         //カレンダーの表示に必要なデータを配列に格納
         $data = [
             "year" => $year,
             "month" => $month,
             "daysInMonth" => $daysInMonth,
             "startOfMonth" => $startOfMonth,
             "endOfMonth" => $endOfMonth,
             "events" =>$events,   
             "calstatuses" => $calstatuses,
            ];
             //カレンダーのビューを表示
         // return view('cal.index',$data);
         return view('cal.create',$data);
    }


    public function store(StoreCalRequest $request)
    {
        
        DB::beginTransaction();
        
        try{
         
            $date = $request->input('date');
            $timestamp = strtotime($date);
            $date_id = date('d', $timestamp);
            $time_id = date('H', $timestamp);
            // dd($date_id);

            $cal = Cal::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'timeid' =>$time_id,
                'dateid' => $date_id,
                'date' =>$request->date,
                'importance' => $request->importance,
                
            ]);   
            $cal->save();
            
        
            
            // strtotimeの取得やdateメソッドにて数字を取得する際について   https://hara-chan.com/it/programming/php-function-date-strtotime/
           
            /*$date = $request->input('date');
            $pp =date('Y-m-d',strtomtime($date));
            dd($date);*/
            DB::commit();

        }catch(\Exception $e) {

            DB::rollBack();

            Log::debug($e);

            abort(500);
        }
        return redirect()->route('cal.index');
    }

    /**
     * 予定編集画面
     */
    public function edit($id,Request $request)
    {
        // dd($id);
        $cal = Cal::where('id',$id)->get();

        $now = Carbon::now();
         
         //表示する年月を取得
         $year = $request->input('year',$now->year);
         $month = $request->input('month',$now->month);
 
         //カレンダーを表示する日時を取得
         $daysInMonth = Carbon::createFromDate($year,$month)->daysInMonth;
         // Carbonライブラリを使用して、指定された年と月に対して、その月の日数を計算している。
         // $daysInMonth = Carbon::createFromDateのメソッドで指定された年と月のcarbonインスタンスを作成する。
 
         $startOfMonth = Carbon::createFromDate($year,$month)->startOfMonth();
         $endOfMonth = Carbon::createFromDate($year,$month)->endOfMonth();

        $calStatusStrings = Cal::CAL_STATUS_STRING;
        // dd($cal);
        $data = [
            "year" => $year,
            "month" => $month,
            "daysInMonth" => $daysInMonth,
            "startOfMonth" => $startOfMonth,
            "endOfMonth" => $endOfMonth, 
            "id" => $id , 
            'cal'=> $cal,
            'calStatusStrings' => $calStatusStrings,
            ];

            return view('cal.edit',$data);

    }

    /**
     * 予定編集処理
     */
    public function update(UpdateCalRequest $request,$id)
    {

        $cal = Cal::find($id);
      
        DB::beginTransaction();
        try{

        
        $cal->fill([
            'title' => $request->input('title'),
        'date' => $request->input('date'),
        'importance' => $request->input('importance'),
        'dateid' => date('d', strtotime($request->input('date'))),
        'timeid' => date('H', strtotime($request->input('date')))])->save();
        // 'timeid' はカラム名を指している

        $cal->save();
      
//   dd($cal);
        DB::commit();


        // サイド画面表示のコード
        $now = Carbon::now();
        //表示する年月を取得
        $year = $request->input('year',$now->year);
        $month = $request->input('month',$now->month);
        //カレンダーを表示する日時を取得
        $daysInMonth = Carbon::createFromDate($year,$month)->daysInMonth;
        // Carbonライブラリを使用して、指定された年と月に対して、その月の日数を計算している。
        // $daysInMonth = Carbon::createFromDateのメソッドで指定された年と月のcarbonインスタンスを作成する。
        $startOfMonth = Carbon::createFromDate($year,$month)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year,$month)->endOfMonth();

       $calStatusStrings = Cal::CAL_STATUS_STRING;
       $data = [
           "year" => $year,
           "month" => $month,
           "daysInMonth" => $daysInMonth,
           "startOfMonth" => $startOfMonth,
           "endOfMonth" => $endOfMonth, 
           "id" => $id , 
           'cal'=> $cal,
           'calStatusStrings' => $calStatusStrings,
           ];
        }catch(\Evception $e) {

            DB::rollBack();

            Log::debug($e);

            abort(500);
        }

      

        return redirect()->route('cal.index',[
            'id' => $id,
        ]);
    }
    public function delete($id,Request $request)
{
    DB::beginTransaction();
    try{
        $cal = Cal::find($id);
        
        $cal->delete();
        DB::commit();

        $now = Carbon::now();
       
         //表示する年月を取得
         $year = $request->input('year',$now->year);
         $month = $request->input('month',$now->month);
 
         //カレンダーを表示する日時を取得
         $daysInMonth = Carbon::createFromDate($year,$month)->daysInMonth;
         // Carbonライブラリを使用して、指定された年と月に対して、その月の日数を計算している。
         // $daysInMonth = Carbon::createFromDateのメソッドで指定された年と月のcarbonインスタンスを作成する。
 
         $startOfMonth = Carbon::createFromDate($year,$month)->startOfMonth();
         $endOfMonth = Carbon::createFromDate($year,$month)->endOfMonth();

    }catch(\Exception $e) {
        DB::rolllBack();
        Log::debug($e);
        abort(500);
    }
    return redirect()->route('cal.index');

}
}