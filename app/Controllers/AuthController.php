<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function logout()
    {
        $session = session();

        if ($session->has('user_id')) {
            
            $session->remove('user_id');
            $session->destroy();         
        }

        return redirect()->to('/login');
    }
}
