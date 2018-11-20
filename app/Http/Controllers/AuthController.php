<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
	protected $authService;

	/**
	 * @param AuthService $authService
	 */
	public function __construct( AuthService $authService )
	{
		$this->authService = $authService;
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login( Request $request )
	{
		if ( ! $token = $this->authService->login( $request->email, $request->password ) ) {
			return response()->json( [ 'error' => 'invalid_credentials' ], 401 );
		}

		return response()->json( [ 'token' => $token ] );
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function logout( Request $request )
	{
		$this->authService->logout( $request );

		return response()->json();
	}
}
