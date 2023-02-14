<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserValidationService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var UserValidationService
     */
    protected $userValidationService;

    public function __construct(UserRepository $userRepository, UserValidationService $userValidationService)
    {
        $this->userRepository = $userRepository;
        $this->userValidationService = $userValidationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UserCollection(
            $this->userRepository->getAll()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\User\StoreUserRequest $request
     * @param  App\Repositories\UserRepository $userRepository
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate the Request
        $this->userValidationService->validateCreate($request->all());

        //Sote the data to db
        $user = $this->userRepository->create($request);
        return new UserResource($user);
    }

    public function show($id)
    {
        return new UserResource($this->userRepository->find($id));
    }

    public function update(Request $request, $id)
    {
        $user = $this->userRepository->find($id);

        $this->userValidationService->validateUpdate($request->all(), $user);

        $user = $this->userRepository->update($user, $request->all());

        return new UserResource($user);
    }

    public function destroy($id)
    {
        $this->userRepository->delete($id);

        return response()->json(null, 204);
    }
}
