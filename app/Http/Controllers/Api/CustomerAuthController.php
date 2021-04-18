<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'mobile' => 'required',
        ]);

        $customer = Customer::create([
            'name' => $data['name'],
            'password' => bcrypt($data['password']),
            'email' => $data['email'],
            'mobile' => $data['mobile'],
        ]);

        return response()->json([
            'customer' => $customer,
            'token' => $customer->createToken('Api Customer Token', ['role:customer'])->plainTextToken
        ]);
    }

    public function login(Request $request)
    {

        $data = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);
//        dd($data);

        if (!Auth::attempt($data)) {
            return $this->error('Credentials not match', 401);
        }

        return $this->success([
            'token' => auth()->user()->createToken('Api Customer Token')->plainTextToken
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout successfully'
        ], 200);
    }


    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
        ]);
        $user = auth()->user();
        $user->name = $request->name;
        $user->save();
        return response()->json([
            'message' => 'Customer Updated Profile Successfully',
            'data' => $user
        ], 200);
    }

    public function editPassword()
    {
        $user = Customer::find(\auth()->user()->id);
        $requestData = \request()->all();
        if(\request()->password){
            $requestData['password'] = bcrypt($requestData['password']);
        }
        else{
            unset($requestData['password']);
        }
        $user->update($requestData);
        return response()->json([
            'message' => 'Customer Updated Password Successfully',
            'data' => $user
        ], 200);
    }

}
