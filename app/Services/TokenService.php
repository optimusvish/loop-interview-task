<?php

namespace App\Services;

use Laravel\Passport\Client;
use Laravel\Passport\PersonalAccessTokenResult;
use Laravel\Passport\Token;
use Illuminate\Database\Eloquent\Model;

class TokenService
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function generateToken(Model $model, string $name, array $scopes = []): PersonalAccessTokenResult
    {
        return $model->createToken($name, $scopes);
    }

    public function revokeToken(Token $token): void
    {
        $token->revoke();
    }
}
