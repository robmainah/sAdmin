<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\LoginRequest;
use App\Http\Requests\Customer\RegisterRequest;
use App\Http\Resources\Customer\CustomerResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login']]);
    // }

    public function register(RegisterRequest $request)
    {
        $customer = Customer::create([
            'name' => $request->name,
            'code' => Customer::generateCustomerCode(),
            'email' => $request->email,
            'phoneNumber' => $request->phone_number,
            'idNumber' => $request->id_number,
            'address' => $request->address,
            'gender' => $request->gender,
            'password' => bcrypt($request->password),
        ]);

        if (!$token = auth()->attempt($request->only(['email', 'password']))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return (new CustomerResource($request->user()))->additional([
            'meta' => [
                'token' => $token
            ]
        ]);
    }

    public function login(LoginRequest $request)
    {
        if (!$token = auth()->attempt($request->only(['email', 'password']))) {
            return response()->json([
                "errors" => [
                    "email" => [
                        0 => "Wrong credentials given"
                    ]
                ]
            ], 422);
        }

        return (new CustomerResource($request->user()))->additional([
            'meta' => [
                'token' => $token
            ]
        ]);
    }

    public function user(Request $request)
    {
        return new CustomerResource($request->user());
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out'], Response::HTTP_OK);
    }
}
