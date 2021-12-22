<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Date;
use Illuminate\Support\Facades\DB;
class CalendarController extends Controller
{
    public function calendar(){
        $dat = DB::table('dates')->select('c_date','status')->get();
        // $statuses = DB::table('dates')->select('status')->get();
        
        $check2 = [];
        $check1 = [];
        $datecheck = [];


        foreach($dat as $d){
            // if($d->status == 0){
            //     array_push($check1,$d->status);

            // }else{
            //     array_push($check2,$d->status);

            // }
            $check1[$d -> c_date] = $d-> status;
            array_push($datecheck,$d->c_date);
            // array_push($dates,["date" => $d->c_date,"status" => $d->status]);
            // array_push($check,$d->c_date);

        }
        $check1 = json_encode($check1);
        $check2 = json_encode($check2);
        $datecheck = json_encode($datecheck);


        // dd($check1);
        return view('admin.calendar.show',compact('check2','check1','datecheck'));
    }


    public function saveDate(Request $request){
        $date= $request->date;
        $MyGivenDateIn = strtotime($date);
        $ConverDate = date("l", $MyGivenDateIn);
        $ConverDateTomatch = strtolower($ConverDate);

        $cdate = Date::where('c_date',$date)->first();
        if(!empty($cdate)){
            $cdate->c_date = $date;
            $cdate->day = $ConverDateTomatch;
            if($cdate->status == 0){
                $cdate->status = 1;
            }else{
                $cdate->status = 0;
            }

            $cdate->save();
            
        }else{
            $cdate = new Date();
            $cdate->c_date = $date;
            $cdate->day = $ConverDateTomatch;
            if(($ConverDateTomatch == "saturday" )|| ($ConverDateTomatch == "sunday")){
                $cdate->status = 1;
            } else {
                $cdate->status = 0;
            }

            $cdate->save();
        }

        $response = [
            'data' => 'Status changed successfully'
        ];


        return response(json_encode($response));
        
    }
}
