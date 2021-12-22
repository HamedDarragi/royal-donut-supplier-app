<?php
namespace App\Http\Controllers\API;
use Exception;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\CrudRepository;
use App\Models\ManufacturingPartner;
use Illuminate\Support\Facades\Http;


class CustomerController extends Controller
{
    protected $crud_repository;
    protected $model = "Customer";
    protected $view = 'customer';
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
        $customers = app('App\\Models\\' . $this->model)->all();
        $view = $this->view;
        return view('mycomponent.datatable', compact('customers', 'view'));
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'mobilenumber' => 'required',
            'address' => 'required',
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = app('App\\Models\\' . $this->model)->find($id);
        $view = $this->view;
        return view('catalog.'.$this->view.'.create', compact('customer', 'view'));
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

    public function search(Request $request)
    {
        $view=$this->view;
        $q = $request->get ( 'search' );
        $customers = app('App\\Models\\' . $this->model)::where('first_name','LIKE','%'.$q.'%')->orWhere('last_name','LIKE','%'.$q.'%')->get();  
       
        if(count($customers) > 0)
          return view('mycomponent.datatable',compact('customers','view'));
        else 
        return view('mycomponent.datatable',compact('customers','view'));
    }
    public function customerlogin(Request $request)
    {
     //  return response()->json('--');
     $customer=Customer::where('email',$request->email)->where('password', $request->password)->first();
      return response()->json($customer); 
      //  return view('mycomponent.datatable',compact('orders', 'view'));
    }

    public function login()
    {
        //$view='order';
        $response = Http::post('http://127.0.0.1:7000/api/login');
        
         $orders=$response->body();
         $orders =json_decode($orders);
         dd($orders);
        
      //  return view('mycomponent.datatable',compact('orders', 'view'));
    }
}
