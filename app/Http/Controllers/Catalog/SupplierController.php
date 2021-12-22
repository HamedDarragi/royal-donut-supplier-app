<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CrudRepository;
use App\Models\Order;
use App\Models\Cart;
use App\Models\User;
use App\Models\DeliveryCompany;
use App\Models\CompanySupplier;
use Spatie\Activitylog\Models\Activity;



class SupplierController extends Controller
{
    protected $crud_repository;
    protected $model = "User";
    protected $role = "Supplier";
    protected $view = 'supplier';
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
        
        $suppliers = app('App\\Models\\' . $this->model)::role('Supplier')->get();
        

        $view = $this->view;
        return view('mycomponent.datatable', compact('suppliers', 'view'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
       $companies = DeliveryCompany::all();

        return view('catalog.'.$this->view.'.create',compact('companies'));
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
            'abbrivation' => 'required|max:2|min:2|unique:users',
        ]);


        $message = $this->crud_repository->registerNewUser($request, $this->model, $this->role);

        

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
        $supplier = app('App\\Models\\' . $this->model)->find($id);
       $companies = DeliveryCompany::all();


        $view = $this->view;
        return view('catalog.'.$this->view.'.create', compact('supplier', 'view','companies'));
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
        
        $request->validate([
            'abbrivation' => 'required|max:2|min:2',
        ]);
        $message = $this->crud_repository->update($request, $id, $this->model);
        // dd($message);
        $user = User::find($id);
        //$user->abbrivation = $request->abbrivation;
        // $user->zip_code = $request->zip_code;
        $user->save();
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
        $ca = Cart::where('supplier_id',$id)->get();
            $oa = Order::where('supplier_id',$id)->get();
            foreach($ca as $c){
                $c->delete();
            }
            foreach($oa as $o){
                $o->delete();
            }
        $message = $this->crud_repository->destroy($id, $this->model);
        return redirect()->route($this->view.'.index')->with('status', $this->model . $message);
    }

    public function status($id)
    {
        // dd($id);
        $message = $this->crud_repository->status($id, $this->model);
        return redirect()->route($this->view.'.index')->with('status', $this->model . $message);
    }
    public function search(Request $request)
    {
        $view=$this->view;
        $q = $request->get('search');
        
        $suppliers = app('App\\Models\\' . $this->model)::where('first_name','LIKE','%'.$q.'%')->orWhere('last_name','LIKE','%'.$q.'%')->get();  
        if(count($suppliers) > 0)
          return view('mycomponent.datatable',compact('suppliers','view'));
        else 
        return view('mycomponent.datatable',compact('suppliers','view'));
    }


    public function getHeader(Request $request,$id){

        $supplier = User::find($id);
        return view('catalog.supplier.setheader',compact('supplier'));
    }

    public function editHeader(Request $request){

        $u = User::find($request->id);
        // dd($u);
        if(!empty($request->description)){
            $u->header = $request->description;
        }

        $u->save();



        return redirect()->route($this->view.'.index')->with('status',"Header updated successfully");

    }
}
