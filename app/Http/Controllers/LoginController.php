<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoginResource;
use App\Services\AuthenticationService;
use App\Services\TokenService;
use App\Services\UserValidationService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    /**
     * @var TokenService
     */
    private $tokenService;
    /**
     * @var UserValidationService
     */
    protected $userValidationService;

    /**
     * LoginController constructor.
     *
     * @param AuthenticationService $authenticationService
     * @param TokenService $tokenService
     */
    public function __construct(AuthenticationService $authenticationService, TokenService $tokenService, UserValidationService $userValidationService)
    {
        $this->authenticationService = $authenticationService;
        $this->tokenService = $tokenService;
        $this->userValidationService = $userValidationService;
    }

    /**
     * Handle the login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        //Validate the Request
        $this->userValidationService->validateLogin($request->all());

        // Authenticate the user using the authentication service
        $user = $this->authenticationService->authenticate($request->all());

        // Generate the authentication token using the token service
        $token = $this->tokenService->generateToken($user, 'LaravelRestApi');

        // Return the response
        return (new LoginResource($token))
            ->response()
            ->setStatusCode(200);
    }
}
