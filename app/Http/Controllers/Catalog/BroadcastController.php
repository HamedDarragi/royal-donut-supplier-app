<?php

namespace App\Http\Controllers\Catalog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CrudRepository;
use App\Models\BroadcastGroup;
use App\Models\BroadcastHistory;
use App\Models\BroadcastGroupDetail;
use Carbon\Carbon;
class BroadcastController extends Controller
{
    protected $crud_repository;
    protected $model = "Broadcast";
    protected $view = 'broadcast';
    // index
    // edit
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(CrudRepository $crud_repository)
    {
        $this->crud_repository = $crud_repository;
    }
    public function index()
    {
        $groups=BroadcastGroup::all();
        $broadcasts = app('App\\Models\\' . $this->model)->all();
        $view = $this->view;
        return view('mycomponent.datatable', compact('broadcasts','groups', 'view'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
       return view('catalog.'.$this->view.'.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required',
            'expiry_date' => 'required',
            'isActive' => 'required'
        ]);
      

        $message = $this->crud_repository->storeWithSingleImage($request, $this->model);
       
        return redirect()->route($this->view.'.index')->with('status', $this->model . $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $broadcast = app('App\\Models\\' . $this->model)->find($id);
        $view = $this->view;
        return view('catalog.'.$this->view.'.create', compact('broadcast', 'view'));
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
        $message = $this->crud_repository->update($request, $id, $this->model);
        return redirect()->route($this->view.'.index')->with('status', $this->model . $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = $this->crud_repository->destroy($id, $this->model);
        return redirect()->route($this->view.'.index')->with('status', $this->model . $message);
    }

    public function status($id)
    {
        $message = $this->crud_repository->status($id, $this->model);
        return redirect()->route($this->view.'.index')->with('status', $this->model . $message);
    }
    public function broadcast_status(Request $request)
    {
        $group = session()->get('groupId');

        $data=null;
        
        if($group != null)
      {
      
            $id=$request->id;
            $broadcast=app('App\\Models\\' . $this->model)::find($id);
            $status=$broadcast->isActive;
            $expiry_date=$broadcast->expiry_date;

            if(($status == 1)&&( $expiry_date >= Carbon::now()))
            {
                
          app('App\\Models\\' . $this->model)::where('id',$request->id)->update(
            [
                'isSent' => 1
            ]);
    
            BroadcastHistory::create([
                'sending_date'=> Carbon::now(),
                'sending_time'=> Carbon::now(),
                'broadcast_group_id'=>$group[0],
                'broadcast_id'=>$id
               ]);
               
                 $data="sent";

               

                }
                else
                  $data='Please activate announcement or check expiry date';
                
          }
                else
                {
                  
                $data='Please select the group';
                }
                session()->put('groupId',[]);
                return response()->json($data);

            }

            public function search(Request $request)
            {
                $view=$this->view;
                $groups=BroadcastGroup::all();

                $q = $request->get ( 'search' );
                $broadcasts = app('App\\Models\\' . $this->model)::where('message','LIKE','%'.$q.'%')->orWhere('title','LIKE','%'.$q.'%')->get();  
                if(count($broadcasts) > 0)
                  return view('mycomponent.datatable',compact('broadcasts','view','groups'));
                else 
                return view('mycomponent.datatable',compact('broadcasts','view','groups'));
            }
    }
  

