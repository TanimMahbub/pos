<?php

namespace App\Helper;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JWTToken {
    public static function CreateToken($userEmail):string {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24),
            'userEmail' => $userEmail
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

    public static function VerifyToken($token) {
        try {
            $key = env('JWT_KEY');
            $decode = JWT::decode($token, new Key($key, 'HS256'));
            return $decode->userEmail;
        } catch (Exception $e) {
            return 'Unauthorized';
        }
    }

    public static function Token4Reset($userEmail):string {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time() + (60 * 20),
            'userEmail' => $userEmail
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

}