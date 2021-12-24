<?php

namespace App\Repositories;

use Exception;
use App\Models\User;
use App\Models\DeliveryCompany;
use App\Models\CompanySupplier;

use Illuminate\Support\Facades\DB;

class CrudRepository
{
    private $model;

    public function storeWithSingleImage($request, $model)
    {
        DB::beginTransaction();
        try {

            $this->model = app('App\\Models\\' . $model);
            $data = $this->model->create($request->only($this->model->getFillable()));
            if ($request->file('image')) {
                $imageName = time() . rand(1, 10000) . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images/' . $model), $imageName);
                $data->update([
                    'image' => $imageName
                ]);
            }
            DB::commit();
            return trans('message.Success_created');
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function storeWithOutImage($request, $model)
    {
        DB::beginTransaction();
        try {
            $this->model = app('App\\Models\\' . $model);
            $data = $this->model->create($request->only($this->model->getFillable()));

            DB::commit();
            return trans('message.Success_created');
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function registerNewUser($request, $model, $role)
    {

        $request->validate([
            'email' => 'unique:users'
        ]);
        DB::beginTransaction();
        try {
            $this->model = app('App\\Models\\' . $model);
            $data = $this->model->create($request->only($this->model->getFillable()));
            if($role == "Supplier"){
                if(isset($request->company) && count($request->company) > 0){
                    for($i=0; $i < count($request->company); $i++){
                        
                            $company_sup = new CompanySupplier();
                            $company_sup->delivery_company_id = $request->company[$i];
                            $company_sup->supplier_id = $data->id;
                            $company_sup->save();
                        
                    }
                    
                }
                $data->abbrivation = $request->abbrivation;
                // $data->zip_code = $request->zip_code;

                $data->save();
            }
            
            if($role == "Customer"){
                //$data->abbrivation = $request->abbrivation;
                $data->zip_code = $request->zip_code;
                $data->city = $request->city;
                $data->save();
            }
            $data->assignRole($role);
            DB::commit();
            return trans('message.Success_created');
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function update($request, $id, $model)
    {
        DB::beginTransaction();
        try {
            // if($model == "DeliveryCompany"){
            //     $u = DeliveryCompany::where('name',$request->name)->first();
            //     // dd($u);
            //     $user = DeliveryCompany::find($id);
            //     if(empty($u) && $user->name != $request->name){
            //         $data->name = $request->name;
            //         // dd($data);
            //         $data->save();

            //         DB::commit();
            //         return trans('message.Success_updated');
            //     }
               
            // }



            $this->model = app('App\\Models\\' . $model);
            $data = $this->model::find($id);
            //delete image in array by value "image"
            $fill = $this->model->getFillable();
            if (($key = array_search("abbrivation", $fill)) !== false) {
                unset($fill[$key]);
            }
            // dd($fill);
            if (($key = array_search("image", $fill)) !== false) {
                unset($fill[$key]);
            }
            if (empty($request->password)) {
                if (($key = array_search("password", $fill)) !== false) {
                    unset($fill[$key]);
                }
            }
            $data->update($request->only($fill));
            
                if(!empty($request->abbrivation)){
                    $u = User::where('abbrivation',$request->abbrivation)->first();
                    // dd($u);
                    $user = User::find($id);
                    if(empty($u) && $user->abbrivation != $request->abbrivation){
                        $data->abbrivation = $request->abbrivation;
                    }
                }
                if(!empty($request->zip_code)){
                    $data->zip_code = $request->zip_code;
                    $data->city = $request->city;
                    $data->save();
                }
                if(!empty($data->abbrivation) ){
                    // dd('hhh');
                    $company_sups = CompanySupplier::where('supplier_id',$id)->get();
                    foreach($company_sups as $c){
                        $c->delete();
                    }
                }
                
                if(isset($request->company) && count($request->company) > 0){
                    
                        for($i=0; $i < count($request->company); $i++){
                        
                        
                            $company_sup = new CompanySupplier();
                            $company_sup->delivery_company_id = $request->company[$i];
                            $company_sup->supplier_id = $data->id;
                            $company_sup->save();

                            
                        }
                        
                    }
                    
                
                
            

            if ($request->has('image')) {
                if (file_exists(public_path() . 'images/' . $model . '/' . $data->image)) {
                    unlink(public_path() . 'images/' . $model . '/' . $data->image);
                }

                $imageName = time() . rand(1, 10000) . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images/' . $model), $imageName);
                $data->update([
                    'image' => $imageName
                ]);
            }
            DB::commit();
            return trans('message.Success_updated');
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function destroy($id, $model)
    {
        DB::beginTransaction();
        try {
            $this->model = app('App\\Models\\' . $model);
            $data = $this->model::find($id);
            if (!empty($data->image)) {
                if ($data->image != 'default.png')
                    if (file_exists(public_path() . 'images/' . $model . '/' . $data->image)) {
                        unlink(public_path() . 'images/' . $model . '/' . $data->image);
                    }
            }
            $data->delete();
            DB::commit();
            return trans('message.Success_deleted');
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
    public function getAllData($model)
    {
        $this->model = app('App\\Models\\' . $model);
        $entries = $this->model::get();
        return $entries;
    }
    public function getById($id, $model)
    {
        $this->model = app('App\\Models\\' . $model);
        $entry = $this->model::find($id);
        return $entry;
    }


    public function status($id, $model)
    {

        DB::beginTransaction();
        // try {
        $this->model = app('App\\Models\\' . $model);

        $data = $this->model::find($id);

        if ($data->isActive == 1) {
            $data->update([
                'isActive' => 0
            ]);
        } else {

            $data->update([
                'isActive' => 1
            ]);
        }
        DB::commit();
        return trans('message.Success_status');
        // } catch (Exception $e) {
        //     DB::rollback();
        //     return $e->getMessage();
        // }
    }
}
