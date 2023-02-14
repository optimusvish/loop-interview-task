<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthenticationService
{
    /**
     * Authenticate the user.
     *
     * @param array $credentials
     * @return User|null
     */
    public function authenticate(array $credentials)
    {
        if (Auth::attempt($credentials)) {
            return Auth::user();
        }

        $this->unauthenticated();
    }

    // UnAuthenticated
    public function unauthenticated()
    {
        return throw new HttpResponseException(
            response()->json(
                ['message' => 'Unauthenticated'],
                401
            )
        );
    }
}
