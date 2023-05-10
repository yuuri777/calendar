<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCalRequest;
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
        
        // dd($request);
        //表示する現在の年月を取得
        $year = $request->input('year',$now->year);
    
        $month = $request->input('month',$now->month);
       
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
    
        $events = Cal::all();
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
            $cal = Cal::create([
                'user_id' => Auth::id(),
                'date' =>$request->date,
                'title' => $request->title,
                'importance' => $request->importance,
            ]);
        
            $cal->save();
            dd("cal");

            DB::commit();

        }catch(\Exception $e) {

            DB::rollBack();

            Log::debug($e);

            abort(500);
        }
        return redirect()->route('cal.index');
    }

}
