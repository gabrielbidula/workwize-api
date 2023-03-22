<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\SignupRequest;
use App\Http\Resources\Api\Auth\AuthResource;
use App\Interfaces\ISignupService;
use Illuminate\Http\JsonResponse;

class SupplierSignupController extends Controller
{
    public function __construct(protected ISignupService $signupService)
    {
    }

    public function signup(SignupRequest $request): JsonResponse
    {
        $data['credentials'] = $request->validated();

        $token = $this->signupService->signup(array_merge($data, ['role' => RoleEnum::SUPPLIER]));

        return response()->json(new AuthResource($token), 201);
    }
}
