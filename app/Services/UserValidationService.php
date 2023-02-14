<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserValidationService
{
    protected $validator;

    public function __construct(ValidationFactory $validator)
    {
        $this->validator = $validator;
    }

    public function validateCreate(array $data)
    {
        $validator = $this->validator->make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            $this->failedValidation($validator);
        }

        return $data;
    }

    public function validateUpdate(array $data, User $user)
    {
        $validator = $this->validator->make($data, [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:4',
        ]);

        if ($validator->fails()) {
            $this->failedValidation($validator);
        }

        return $data;
    }

    public function validateLogin(array $data)
    {
        $validator = $this->validator->make($data, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            $this->failedValidation($validator);
        }

        return $data;
    }

    /**
     * Get the validation errors and process with Validator Class.
     *
     * @return array
     */
    public function failedValidation($validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
