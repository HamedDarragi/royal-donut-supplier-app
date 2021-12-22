<?php

namespace App\Http\Controllers\Catalog;
use App\Models\Unit;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CrudRepository;

class InventoryController extends Controller
{
    protected $crud_repository;
    protected $model = "Inventory";
    protected $view = 'inventory';
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
        $inventories = Inventory::all();
        $view = $this->view;
        return view('mycomponent.datatable', compact('inventories', 'view'))->with('product','unit');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::IsActive()->get();
        $units=  Unit::IsActive()->get();
        $view = $this->view;
        return view('catalog.'.$this->view.'.create', compact('view','products','units'));
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
            'product_id' => 'required',
            'quantity' => 'required',
            'unit_id' => 'required'

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
        $model=$this->model;
        $inventory = app('App\\Models\\' . $model)::find($id);
        $products = Product::IsActive()->get();
        $units=  Unit::IsActive()->get();
        $view = $this->view;
        return view('catalog.'.$this->view.'.create', compact('inventory', 'view','products','units'))->with('product','unit');

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

    public function search(Request $request)
    {
        $view=$this->view;
        $q = $request->get ( 'search' );
        $inventories = app('App\\Models\\' . $this->model)::where('name','LIKE','%'.$q.'%')->get();  
       
        if(count($inventories) > 0)
          return view('mycomponent.datatable',compact('inventories','view'));
        else 
        return view('mycomponent.datatable',compact('inventories','view'));
    }
   
}
