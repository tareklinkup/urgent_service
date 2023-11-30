<?php

namespace App\Http\Controllers;

use App\Models\TruckType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TruckTypeController extends Controller
{
    //store procedure

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                "name" => "required"
            ],["name.required" => "TruckType name required"]);
            if($validator->fails()){
                return response()->json(["error" => $validator->errors()]);
            }else{
                if(empty($request->id)){
                    $data = new TruckType();
                }else{
                    $data = TruckType::find($request->id);
                }
                $data->name = $request->name;
                $data->save();
                $id = $data->id;
                if(empty($request->id)){
                    return response()->json(["msg"=>"TruckType added successfully"]);
                }else{
                    return response()->json(["msg"=>"TruckType updated successfully"]);
                }
            }
        }catch(\Throwable $e){
            return response()->json("Something went wrong");
        }
    }
}