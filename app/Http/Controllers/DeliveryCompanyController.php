<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CrudRepository;
use App\Models\DeliveryCompany;
use App\Models\CompanySupplier;


class DeliveryCompanyController extends Controller
{
    protected $crud_repository;
    protected $model = "DeliveryCompany";
    protected $view = 'deliverycompany';
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
        $companies = app('App\\Models\\' . $this->model)::all();
        $view = $this->view;
        return view('mycomponent.datatable', compact('companies', 'view'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $view = $this->view;
        return view('catalog.'.$this->view.'.create', compact('view'));
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
            'name' => 'required|unique:delivery_companies',
            'minimum_order_amount' =>  'required',
            'delivery_fee' => 'required'

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
        $company = app('App\\Models\\' . $model)::find($id);
       
        $view = $this->view;
        return view('catalog.'.$this->view.'.create', compact('company', 'view'));
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
            'name' => 'required',
            'minimum_order_amount' =>  'required',
            'delivery_fee' => 'required'

        ]);
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
        $company_sups = CompanySupplier::where('delivery_company_id',$id)->get();
        if(isset($company_sups) && count($company_sups) > 0){
            foreach($company_sups as $c){
                $c->delete();
            }
        }
                    
        $message = $this->crud_repository->destroy($id, $this->model);
        return redirect()->route($this->view.'.index')->with('status', $this->model . $message);
    }
}
