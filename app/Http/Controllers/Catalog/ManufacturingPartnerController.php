<?php
namespace App\Http\Controllers\Catalog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CrudRepository;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
class ManufacturingPartnerController extends Controller
{
    protected $crud_repository;
    protected $model = "User";
    protected $view = 'manufacturing_partner';
    protected $role = 'Manufacturer';

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
        $manufacturing_partners = app('App\\Models\\' . $this->model)::role('Manufacturer')->get();
        $view = $this->view;
        return view('mycomponent.datatable', compact('manufacturing_partners', 'view'));
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
            'company'=>'required'
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
        $manufacturing_partner = app('App\\Models\\' . $this->model)->find($id);
        $view = $this->view;
        return view('catalog.'.$this->view.'.create', compact('manufacturing_partner', 'view'));
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

        $products = Product::where('manufacturing_partner_id',$id)->get();
        foreach($products as $p){
            $ca = Cart::where('product_id',$p->id)->get();
            $oa = Order::all();
            foreach($ca as $c){
                $c->delete();
            }
            foreach($oa as $o){
                $arr = json_decode($o->product_id);
                if(in_array($p->id,$arr)){
                    $o->delete();
                }
            }


            $p->delete();
        }
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
        $manufacturing_partners = app('App\\Models\\' . $this->model)::where('first_name','LIKE','%'.$q.'%')->orWhere('last_name','LIKE','%'.$q.'%')->get();  
       
        if(count($manufacturing_partners) > 0)
          return view('mycomponent.datatable',compact('manufacturing_partners','view'));
        else 
        return view('mycomponent.datatable',compact('manufacturing_partners','view'));
    }
}
