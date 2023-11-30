<?php

namespace App\Http\Controllers\Admin;

use App\Models\TruckRent;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoryWiseTruck;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class TruckRentController extends Controller
{

    public function create()
    {
        return view('admin.truck.truckCreate');
    }

    public function store(Request $request)
    {
        try {

            // dd($request->all());

            $validator = Validator::make($request->all(), [
                "name"           => "required",
                "username"       => "required|unique:privatecars",
                "password"       => "required",
                "email"          => "required|email",
                "phone"          => "required",
                "city_id"        => "required",
                "upazila_id"     => "required",
                "address"        => "required",
                "car_license"    => "required",
                "driver_license" => "required",
                "driver_nid"     => "required",
                "driver_address" => "required",
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data                 = new TruckRent;
                $data->image          = $this->imageUpload($request, 'image', 'uploads/privatecar') ?? '';
                $data->name           = $request->name;
                $data->username       = $request->username;
                $data->password       = Hash::make($request->password);
                $data->email          = $request->email;
                $data->phone          = implode(",", $request->phone);
                $data->city_id        = $request->city_id;
                $data->upazila_id     = $request->upazila_id;
                $data->address        = $request->address;
                $data->map_link       = $request->map_link;
                $data->car_license    = $request->car_license;
                $data->driver_license = $request->driver_license;
                $data->driver_nid     = $request->driver_nid;
                $data->driver_address = $request->driver_address;
                $data->number_of_seat = $request->number_of_seat;
                $data->description    = $request->description;
                $data->save();

                foreach ($request->truckType_id as $item) {
                    $categoryWiseTruck  = new CategoryWiseTruck;
                    $categoryWiseTruck->truck_id = $data->id;
                    $categoryWiseTruck->trucktype_id = $item;
                    $categoryWiseTruck->save();
                }

                return response()->json("Truck added successfully");
            }
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    public function index()
    {
        //  $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
        //     ->pluck('permissions')
        //     ->toArray();

        // if (!in_array("privatecar.index", $access)) {
        //     return view("admin.unauthorize");
        // }

        $trucks = TruckRent::with('upazila')->latest()->get();
        return view("admin.truck.index", compact("trucks"));

    }

    public function edit($id)
    {
        $data = TruckRent::findOrFail($id);
        return view('admin.truck.edit', compact("data"));
    }

    public function update(Request $request)
    {
        try {

             $validator = Validator::make($request->all(), [
                "name"           => "required",
                "username"       => "required|unique:privatecars,username," . $request->id,
                "email"          => "required|email",
                "phone"          => "required",
                "city_id"        => "required",
                "upazila_id"     => "required",
                "address"        => "required",
                "car_license"    => "required",
                "driver_license" => "required",
                "driver_nid"     => "required",
                "driver_address" => "required",
            ]);

            if($validator->fails()){
                return response()->json(['error' => $validator->errors()]);
            } else {
               $data = TruckRent::find($request->id);
               $old_image = $data->image;

               if($request->hasFile('image'))
               {
                    if(File::exists($old_image)){
                        File::delete($old_image);
                    }
                    $data->image = $this->imageUpload($request, 'image', 'uploads/privatecar') ?? '';
               }

                $data->name   = $request->name;
                $data->username = $request->username;
                if (!empty($request->password)) {
                    $data->password = Hash::make($request->password);
                }
                $data->email          = $request->email;
                $data->phone          = implode(",", $request->phone);
                $data->city_id        = $request->city_id;
                $data->upazila_id     = $request->upazila_id;
                $data->address        = $request->address;
                $data->map_link       = $request->map_link;
                $data->car_license    = $request->car_license;
                $data->driver_license = $request->driver_license;
                $data->driver_nid     = $request->driver_nid;
                $data->driver_address = $request->driver_address;
                $data->number_of_seat = $request->number_of_seat;
                $data->description    = $request->description;
                $data->update();

                CategoryWiseTruck::where('truck_id', $request->truck_id)->delete();
                foreach ($request->cartype_id as $item) {
                    $categoryWiseTruck  = new CategoryWiseTruck();
                    $categoryWiseTruck->truck_id = $data->id;
                    $categoryWiseTruck->trucktype_id    = $item;
                    $categoryWiseTruck->save();
                }

                return response()->json("Privatecar updated successfully");
            }


        }catch(\Throwable $e)
        {
            return response()->json("Something went to Wrong" .$e->getMessage());
        }
    }

    public function destroy(Request $request)
    {

        // $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
        //     ->pluck('permissions')
        //     ->toArray();
        // if (!in_array("privatecar.destroy", $access)) {
        //     return view("admin.unauthorize");
        // }

        try {

            $data = TruckRent::find($request->id);
            $old  = $data->image;
            if (File::exists($old)) {
                File::delete($old);
            }
            $data->delete();
            return response()->json("Truck Deleted successfully");

        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }

    }

}