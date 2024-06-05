<?php

namespace Modules\AuthAdmin\Services;

use Illuminate\Support\Str;

class AuthService
{
    /**
     * Authenticates the admin user.
     * 
     * @param string $login
     * @param string $password
     * @return array
     */
    public function authenticate(string $login, string $password): array
    {
        if ($login === 'admin' && $password === 'admin') {
            $token = Str::random(60); 
            
            return [
                'success' => true,
                'message' => 'Authentication successful',
                'token' => $token
            ];
        }

        return [
            'success' => false,
            'message' => 'Authentication failed'
        ];
    }
}
