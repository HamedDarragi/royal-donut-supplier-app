<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CrudRepository;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;
use DB;

class AdminsController extends Controller
{
    protected $crud_repository;
    protected $model = "User";
    protected $view = 'admins';
    protected $role = 'Admin';
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

        // dd('hjh');
        $adms = app('App\\Models\\' . $this->model)->get();
        $admins = [];
        foreach($adms as $a){
            if(!$a->hasRole('Customer') && !$a->hasRole('Supplier') && !$a->hasRole('SuperAdmin')){
                array_push($admins,$a);
            }
        }
        // dd($admins);
        $view = $this->view;
        return view('mycomponent.datatable', compact('admins', 'view'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderBy('id','DESC')->where('name','!=','Customer')
            ->where('name','!=','Manufacturer')
            ->where('name','!=','Supplier')->where('name','!=','SuperAdmin')->get();
        return view('catalog.' . $this->view . '.create',compact('roles'));
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
            'first_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            

        ]);
        $this->role = $request->user_type;
            $message = $this->crud_repository->registerNewUser($request, $this->model, $this->role);

            // $cust = app('App\\Models\\' . $this->model)::latest()->first();
            // $a = activity()->log('Look mum, I logged something');
            // $a->subject_id = "CUST-".$cust->id;
            // $a->subject_type = "Customer";
            // $a->causer_type = "Admin";
            // $a->properties = 1;
            // $a->action = "Customer Created";
            // $a->save();
            // dd($a);

            return redirect()->route('admins.index')->with('status', $this->model . $message);
       
        
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
        $admin = app('App\\Models\\' . $this->model)->find($id);
        $view = $this->view;
        $roles = Role::orderBy('id','DESC')->where('name','!=','Customer')
        ->where('name','!=','Manufacturer')
        ->where('name','!=','Supplier')->where('name','!=','SuperAdmin')->get();
        return view('catalog.' . $this->view . '.create', compact('admin', 'view','roles'));
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
        // dd($request->all());
        $message = $this->crud_repository->update($request, $id, $this->model);
        // $cust = app('App\\Models\\' . $this->model)::find($id);
        //     $a = activity()->log('Look mum, I logged something');
        //     $a->subject_id = "CUST-".$cust->id;
        //     $a->subject_type = "Customer";
        //     $a->causer_type = "Admin";
        //     $a->properties = 1;
        //     $a->action = "Customer Updated";
        //     $a->save();
        return redirect()->route($this->view . '.index')->with('status', $this->model . $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $cust = app('App\\Models\\' . $this->model)::find($id);
        //     $a = activity()->log('Look mum, I logged something');
        //     $a->subject_id = "CUST-".$cust->id;
        //     $a->subject_type = "Customer";
        //     $a->causer_type = "Admin";
        //     $a->properties = 1;
        //     $a->action = "Customer Deleted";
        //     $a->save();
        $message = $this->crud_repository->destroy($id, $this->model);
        
        return redirect()->route($this->view . '.index')->with('status', $this->model . $message);
    }
}
