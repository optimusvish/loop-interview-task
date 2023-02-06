<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\User\StoreUserRequest;
use Illuminate\Support\Facades\Auth;
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserRepository $user)
    {
        try {
            $user = $user->all();
            return response()->json([
                "data" => [
                    "message" => "Success",
                    "data" => $user,
                ],
            ]);
        } catch (Exception $e) {
            // Handle all exceptions
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginUserRequest $request)
    {
        try {
            if (Auth::attempt($request->validated())) {
                $user = Auth::user();
                $token = $user->createToken("LaravelRestApi")->accessToken;
                $expirationTime = date('Y-m-d H:i:s', strtotime('+30 Minutes'));
                return response()->json([
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'expires_in' => $expirationTime
                ]);
            } else {
                return response()->json(["error" => "Unauthorised"], 401);
            }
        } catch (Exception $e) {
            // Log the full exception details
            Log::info($e);

            // Return a generic error message to the user
            return response()->json([
                'message' => 'An error occurred while processing the request. Please try again later.',
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\User\StoreUserRequest $request
     * @param  App\Repositories\UserRepository $userRepository
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request, UserRepository $userRepository)
    {
        try {
            $user = $userRepository->create($request);
            return response()->json(
                [
                    "data" => [
                        "message" => "User registered successfully!!",
                        "data" => $user,
                    ],
                ],
                201
            );
        } catch (Exception $e) {
            // Log the full exception details
            Log::info($e);

            // Return a generic error message to the user
            return response()->json([
                'message' => 'An error occurred while processing the request. Please try again later.',
            ], 500);
        }
    }
}
