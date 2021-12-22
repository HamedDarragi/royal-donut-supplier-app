<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class BackLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $logs = Activity::paginate(5);

        return view('admin.backlogs.index',compact('logs'));
    }


    public function filter(Request $request)
    {
        $logs = null;
        
        $back = null;
        if(!empty($request->fil) && $request->fil == "All"){
            $logs = Activity::all();
            $back= $request->fil;
        }else if(!empty($request->fil) && $request->fil == "Customer"){
            $logs = Activity::where('subject_type',"Customer")->get();
            $back= $request->fil;
            
        }else if(!empty($request->fil) && $request->fil == "Order"){
            $logs = Activity::where('subject_type',"Order")
            ->get();
            $back= $request->fil;
            
        }else if(!empty($request->fil) && $request->fil == "Email"){
            $logs = Activity::where('subject_type',"Email")
            ->get();
            $back= $request->fil;
            
        }

        

        // $logs = $logs->get();
        // dd($a);
        

        return view('admin.backlogs.search',compact('logs','back'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
