<?php

namespace App\Http\Controllers;

use App\Models\AssociateRule;
use App\Models\Rule;
use App\Models\User;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssociateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $associate = AssociateRule::all();
        return view('admin.delivery.association.index', compact('associate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $customer = User::role('customer')->get();
        $supplier = User::role('supplier')->get();
        $rule = Rule::all();
        // dd($supplier);
        return view('admin.delivery.association.create', compact('customer', 'supplier', 'rule'));
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
        $request->validate([
            '*' => 'required',
            'rule' => 'required',
            'supplier' => 'required',
            'customer' => 'required'

        ]);
        $check_customer_supplier = DB::table('associate_rules')->where('customer_id', $request->customer)->where('supplier_id', $request->supplier)->where('rule_id', $request->rule)->first();
        // dd($check_customer_supplier);
        if ($check_customer_supplier == null) {
            $associate = new AssociateRule();
            $associate->customer_id  = $request->customer;
            $associate->supplier_id = $request->supplier;
            $associate->rule_id = $request->rule;
            $associate->save();
            return redirect()->route('associate_rule.index');
        } else {
            return back()->with('danger', 'Customer With Chosen Supplier is Already Associated, Please Choose Another Customer, Supplier or Rule');
        }
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
        $associate = AssociateRule::find($id);
        $customer = User::role('customer')->get();
        $supplier = User::role('supplier')->get();
        $rule = Rule::all();
        return view('admin.delivery.association.edit', compact('associate', 'customer', 'supplier', 'rule'));
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
        //
        $request->validate([
            '*' => 'required',
            'rule' => 'required',
            'supplier' => 'required',
            'customer' => 'required'

        ]);
        $associated_rule = AssociateRule::find($id);

        // dump($associated_rule->customer_id);
        // dump((int)$request->customer);
        // dump("HERE1");
        if ($associated_rule->customer_id != (int)$request->customer || $associated_rule->supplier_id != (int)$request->supplier || $associated_rule->rule_id != (int)$request->rule) {
            // dd("END");

            $check_customer_supplier = DB::table('associate_rules')->where('customer_id', $request->customer)->where('supplier_id', $request->supplier)->where('rule_id', $request->rule)->first();
            if ($check_customer_supplier == null) {
                $associate = AssociateRule::findorfail($id);
                $associate->customer_id = $request->customer;
                $associate->supplier_id = $request->supplier;
                $associate->rule_id = $request->rule;
                $associate->save();
                return redirect()->route('associate_rule.index');
            } else {
                return back()->with('danger', 'Customer With Chosen Supplier is Already Associated, Please Choose Another Customer, Supplier or Rule');
            }
        } else {
            // dd("END2");
            return redirect()->route('associate_rule.index');
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
        // dd("HERE");
        //
        $associate = AssociateRule::find($id);
        $associate->delete();
        return redirect()->route('associate_rule.index');
    }
}
