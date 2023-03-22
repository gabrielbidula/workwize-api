<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\Api\Auth\AuthResource;
use App\Interfaces\ILoginService;
use Illuminate\Http\JsonResponse;
use Throwable;

class LoginController extends Controller
{
    public function __construct(protected ILoginService $loginService)
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data['credentials'] = $request->validated();

        try {
            $token = $this->loginService->login($data);
        } catch (Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }

        return response()->json(new AuthResource($token));
    }
}
