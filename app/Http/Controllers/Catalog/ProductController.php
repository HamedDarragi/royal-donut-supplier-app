<?php

namespace App\Http\Controllers\Catalog;

use Exception;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Inventory;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\CrudRepository;
use App\Models\ManufacturingPartner;
use Spatie\Permission\Models\Role;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Validation\Rules\Unique;

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
        $products = app('App\\Models\\' . $this->model)::with('category', 'supplier')->orderby('index', 'asc')->get();
        $categories = Category::all();
        $view = $this->view;
        return view('mycomponent.datatable', compact('products', 'view', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = User::role('Supplier')->where('isActive', 1)->get();
        $units = Unit::isActive()->get();
        $manufacturers = User::role('Manufacturer')->where('isActive', 1)->get();

        $categories = Category::IsActive()->get();
        $view = $this->view;
        return view('catalog.' . $this->view . '.create', compact('view', 'categories', 'manufacturers', 'units', 'suppliers'));
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
            'description' => 'required',
            'unit_id' => 'required',
            'index' => 'unique:products',
            'name' => ['string', 'unique:products'],
            'price' => 'required|numeric|gt:0',
            'package' => 'required|numeric|gt:0'
        ]);
        DB::beginTransaction();
        try {
            $previous = DB::table('products')->latest()->first();
            $model = app('App\\Models\\' . $this->model);
            $data = $model->create($request->only($model->getFillable()));

            if ($request->file('image')) {
                $imageName = time() . rand(1, 10000) . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images/' . $this->model), $imageName);
                $data->update([
                    'image' => $imageName
                ]);
            }
            if (empty($previous->index)) {
                $sort = 10000;
            } else {
                $sort = $previous->index;
            }
            $data->update([
                'index' => $sort + 10
            ]);
            DB::commit();
            $message = trans('message.Success_created');
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        return redirect()->route($this->view . '.index')->with('status', $this->model . $message);
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
        $categories = Category::IsActive()->get();
        $manufacturers = User::role('Manufacturer')->isActive()->get();
        $suppliers = User::role('Supplier')->isActive()->get();
        $units = Unit::get();
        $view = $this->view;
        return view('catalog.' . $this->view . '.create', compact('product', 'categories', 'manufacturers', 'view', 'suppliers', 'units'));
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
        // $request->validate([
        //     'description' => 'required',
        //     'unit_id' => 'required',
        //     'index' => 'unique:products',
        //     'name' => ['string', 'unique:products'],
        //     'price' => 'required|numeric|gt:0'
        // ]);
// dd($request->all());
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
                if (file_exists(public_path('images/Product/') . $data->image)) {
                    if ($data->image != 'default.png')
                        unlink(public_path('images/Product/') . $data->image);
                }
                $imageName = time() . rand(1, 10000) . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images/Product/'), $imageName);
                $data->update([
                    'image' => $imageName
                ]);
            }
            DB::commit();
            return redirect()->route($this->view . '.index')->with('status', 'Product' . trans('message.Success_updated'));
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

        $cartItems = \bilawalsh\cart\Models\CartItem::where('product_id', $id)->get();
        foreach ($cartItems as $cartItem) {
            $cartItemCount = \bilawalsh\cart\Models\CartItem::where('cart_id', $cartItem->cart_id)->count();
            if ($cartItemCount < 2) {
                $cartItem->delete();
                \bilawalsh\cart\Models\Cart::where('id', $cartItem->cart_id)->delete();
            } else {
                $cart =   \bilawalsh\cart\Models\Cart::where('id', $cartItem->cart_id)->first();
                $cart->update([
                    'quantity' => $cart->quantity - $cartItem->quantity,
                    'total' => $cart->total - ($cartItem->unit_price *  $cartItem->quantity),
                    'grand_total' => $cart->grand_total - ($cartItem->unit_price *  $cartItem->quantity)
                ]);
                $cartItem->delete();
            }
        }
        $message = $this->crud_repository->destroy($id, $this->model);
        return redirect()->route($this->view . '.index')->with('status', $this->model . $message);
    }

    public function status($id)
    {
        $message = $this->crud_repository->status($id, $this->model);
        return redirect()->route($this->view . '.index')->with('status', $this->model . $message);
    }
    public function search(Request $request)
    {
        $view = $this->view;
        $q = $request->get('search');
        $products = app('App\\Models\\' . $this->model)::where('name', 'LIKE', '%' . $q . '%')->get();
        $inventories = Inventory::with('product')->get();
        if (count($products) > 0)
            return view('mycomponent.datatable', compact('products', 'view', 'inventories'));
        else
            return view('mycomponent.datatable', compact('products', 'view', 'inventories'));
    }



    public function getProducts(Request $request)
    {
        if ($request->id == 'all')
            $products = app('App\\Models\\' . $this->model)::with('supplier')->orderby('index', 'asc')->get();
        else if ($request->id == 'null')
            $products = app('App\\Models\\' . $this->model)::with('category', 'supplier')->whereNull('category_id')->orderby('index', 'asc')->get();
        else
            $products = app('App\\Models\\' . $this->model)::with('category', 'supplier')->where('category_id', $request->id)->orderby('index', 'asc')->get();
        // dd($products);
            return response()->json($products);
    }
}
