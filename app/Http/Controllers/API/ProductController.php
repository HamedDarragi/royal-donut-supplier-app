<?php

namespace App\Http\Controllers\API;
use Exception;
use App\Models\Category;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\CrudRepository;
use App\Models\ManufacturingPartner;
// use Illuminate\Support\Facades\Http;


class ProductController extends Controller
{
    protected $crud_repository;
    protected $model = "Product";
    protected $view = 'product';
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
       
        $products = app('App\\Models\\' . $this->model)->all();
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {    
        $manufacturers=ManufacturingPartner::all();
        $categories = Category::IsActive()->get();
        $view = $this->view;
        return view('catalog.'.$this->view.'.create', compact('view', 'categories','manufacturers'));
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
            '*' => 'required',
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
        $product = app('App\\Models\\' . $this->model)->find($id);
        $view = $this->view;
        return view('catalog.'.$this->view.'.create', compact('product','view'));
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
        // $message = $this->crud_repository->update($request, $id, $this->model);
        DB::beginTransaction();
        try {
            $this->model = app('App\\Models\\' . $this->model);
            $data = $this->model::find($id);
            //delete image in array by value "image"
            $fill = $this->model->getFillable();
            if (($key = array_search("image", $fill)) !== false) {
                unset($fill[$key]);
            }
            $data->update($request->only($fill));
            if ($request->has('image')) {
                if(file_exists(public_path('images/Product/'). $data->image)){
                    unlink(public_path('images/Product/') . $data->image);
                }
                $imageName = time() . rand(1, 10000) . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images/Product/'), $imageName);
                $data->update([
                    'image' => $imageName
                ]);
            }
            DB::commit();
            return redirect()->route($this->view.'.index')->with('status', 'Product' . trans('message.Success_updated'));
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
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
        $products = app('App\\Models\\' . $this->model)::where('name','LIKE','%'.$q.'%')->get();  
        $inventories = Inventory::with('product')->get();
        if(count($products) > 0)
          return view('mycomponent.datatable',compact('products','view','inventories'));
        else 
        return view('mycomponent.datatable',compact('products','view','inventories'));
    }
   
}
