<?php

namespace App\Http\Controllers;

use App\Models\AssociateRule;
use App\Models\Rule;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    protected $crud_repository;
    protected $model = "Rule";
    protected $view = 'rule';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $rule = app('App\\Models\\' . $this->model)->all();
        $view = $this->view;
        // dd($rule);
        return view('admin.delivery.rules.index', compact('rule', 'view'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.delivery.rules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // return dd($request->all());
        $request->validate([
            '*' => 'required',
            'treatment' => 'regex:/^[0-9]+$/|required',
            'delivery' => 'required',
        ]);
        $req = $request->all();
        $rule = new Rule();
        $rule->acceptance_time = $req['acceptance'];
        $rule->treatment_time = $req['treatment'];
        $rule->name = $req['name'];
        $rule->delivery_days = implode(",", $req['delivery']);
        $rule->save();
        return redirect()->route('rule.index');
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
        //
        $rule = Rule::findorfail($id);
        $delivery_days_array = [];
        $delivery_days_array = explode(",", $rule->delivery_days);
        // dd($delivery_days_array);
        return view('admin.delivery.rules.update', compact('rule', 'delivery_days_array'));
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
            '*' => 'required',
            'treatment' => 'regex:/^[0-9]+$/|required',
            'delivery' => 'required',
        ]);
        //
        // dd($id);
        $rule = Rule::findorfail($id);
        $req = $request->all();
        $rule->acceptance_time = $req['acceptance'];
        $rule->treatment_time = $req['treatment'];
        $rule->name = $req['name'];
        $rule->delivery_days = implode(",", $req['delivery']);
        $rule->save();
        return redirect()->route('rule.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $rule = Rule::findorfail($id);
        $rules = AssociateRule::where('rule_id', $id)->get();
        foreach ($rules as $ru) {
            $ru->delete();
        }
        $rule->delete();
        return redirect()->route('rule.index');
    }
}
