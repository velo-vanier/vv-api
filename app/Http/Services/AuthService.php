<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class AuthService
{
	/**
	 * @var JWTAuth
	 */
	protected $jwtAuth;

	public function __construct( JWTAuth $jwtAuth )
	{
		$this->jwtAuth = $jwtAuth;
	}

	/**
	 * @param $email
	 * @param $password
	 *
	 * @return bool|string
	 */
	public function login( $email, $password )
	{
		if ( $password !== env( 'USER_PASSWORD' ) ) {
			return false;
		}

		$user        = new User();
		$user->email = $email;

		$token = $this->jwtAuth->fromUser( $user, [ 'email' => $email ] );

		return $token;
	}

	/**
	 * @param Request $request
	 */
	public function logout( Request $request )
	{
		$token = $this->jwtAuth->setRequest( $request )->getToken();

		$this->jwtAuth->invalidate( $token );
	}

}
