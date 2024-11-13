<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class LoginController extends Controller
{
    public function index()
    {
   
        return view('login');
    }

    public function authenticate()
    {
        helper(['form']);
        $session = session();
        $userModel = new UserModel();
        
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email',
            'mdp' => 'required|min_length[6]',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('mdp');

        $user = $userModel->where('email', $email)->first();

        if ($user) {
           
            if (password_verify($password, $user['password'])) {
                if ($user['is_verified'] == 1) {
                  
                    $session->set([
                        'auth' => true,
                        'iduser' => $user['iduser'],
                        'name' => $user['name'],
                        
                    ]);

                    return redirect()->to('/page-acceuil');
                } else {
                    return redirect()->back()->with('error', 'Veuillez vérifier votre compte avant de vous connecter.');
                }
            } else {
                return redirect()->back()->with('error', 'Mot de passe incorrect.');
            }
        } else {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }
    }
}

?>