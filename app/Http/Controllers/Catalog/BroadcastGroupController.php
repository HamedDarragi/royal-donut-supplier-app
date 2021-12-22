<?php

namespace App\Http\Controllers\Catalog;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\BroadcastGroupDetail;

use App\Http\Controllers\Controller;
use App\Repositories\CrudRepository;

class BroadcastGroupController extends Controller
{
    protected $crud_repository;
    protected $model = "BroadcastGroup";
    protected $view = 'broadcast_group';
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
        $broadcast_groups = $this->crud_repository->getAllData($this->model);
        $view = $this->view;
        return view('mycomponent.datatable', compact('broadcast_groups', 'view'));
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
            'name' => 'required'
        ]);

        $message = $this->crud_repository->storeWithOutImage($request, $this->model);
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
        $broadcast_group = $this->crud_repository->getById($id , $this->model);
        $view = $this->view;
        return view('catalog.'.$this->view.'.create', compact('broadcast_group', 'view'));

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
    public function add_members()
    {
        $groups= app('App\\Models\\' . $this->model)->all();
        return view('catalog.broadcast_group.addmember',compact('groups'));
    }
    public function get_users(Request $request)
    {                                                         //will be modified on creation of roles module
       
        if($request->role_id=='customer')
        {
            $data=Customer::all();
        }
        return response()->json($data);
    }
    public function add_members_store(Request $request)
    {
     
        $users=$request->username;
        $group_id=$request->group_id;

        foreach($users as $user)
        {
            $member=BroadcastGroupDetail::where('customer_id', $user)->where('broadcast_group_id',$group_id)->first();

             if($member == null)
             {
                BroadcastGroupDetail::create(
                    [
                        'customer_id'  =>    $user ,
                        'broadcast_group_id' =>    $group_id
                    ]);
             }

             else
             return back()->with('fail','Member already exist in the group!');

        }
        return back()->with('success','Member added successfully!');
    }
    public function groupId(Request $request)                     
    {
        
        session()->push('groupId',$request->id);
    }

    public function search(Request $request)
    {
        $view=$this->view;
        $q = $request->get ( 'search' );
        $broadcast_groups = app('App\\Models\\' . $this->model)::where('name','LIKE','%'.$q.'%')->get();  
        if(count($broadcast_groups) > 0)
          return view('mycomponent.datatable',compact('broadcast_groups','view'));
        else 
        return view('mycomponent.datatable',compact('broadcast_groups','view'));
    }

    
}
