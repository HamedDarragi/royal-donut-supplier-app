<?php

namespace App\Http\Controllers\Catalog;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CrudRepository;


class CategoryController extends Controller
{
    protected $crud_repository;
    protected $model = "Category";
    protected $view = 'category';
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

        $categories = app('App\\Models\\' . $this->model)->all();
        $view = $this->view;
        return view('mycomponent.datatable', compact('categories', 'view'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('catalog.' . $this->view . '.create');
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
            'name' => 'required|unique:categories',
        ]);
        $message = $this->crud_repository->storeWithSingleImage($request, $this->model);
        return redirect()->route($this->view . '.index')->with('status', $this->model . $message);
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
        $category = app('App\\Models\\' . $this->model)->find($id);
        $view = $this->view;
        return view('catalog.' . $this->view . '.create', compact('category', 'view'));
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
        Product::where('category_id', $id)->update([
            'category_id' => null,
        ]);

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
        $categories = app('App\\Models\\' . $this->model)::where('name', 'LIKE', '%' . $q . '%')->get();
        if (count($categories) > 0)
            return view('mycomponent.datatable', compact('categories', 'view'));
        else
            return view('mycomponent.datatable', compact('categories', 'view'));
    }
}
