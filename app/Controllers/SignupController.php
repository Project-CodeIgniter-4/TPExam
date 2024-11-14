<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class SignupController extends Controller
{
    public function index()
    {
        return view('signup');
    }

    public function register()
    {
        helper(['form', 'url']);
        $userModel = new UserModel();
    
        $validation = \Config\Services::validation();
    
        $validation->setRules([
            'name'     => 'required|min_length[2]',
            'lastname' => 'required|min_length[2]',
            'email'    => 'required|valid_email|is_unique[utilisateur.email]',
            'password' => 'required|min_length[6]',
            'sexe'     => 'required',
            'pdp'      => 'uploaded[pdp]|is_image[pdp]|max_size[pdp,5000]'
        ]);
    
        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }
    
        $file = $this->request->getFile('pdp');
        $imageName = $file->getRandomName();
        // Utiliser FCPATH pour enregistrer dans public/images
        $file->move(FCPATH . 'images', $imageName);
    
        $userData = [
            'name'               => $this->request->getPost('name'),
            'lastname'           => $this->request->getPost('lastname'),
            'email'              => $this->request->getPost('email'),
            'password'           => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'sexe'               => $this->request->getPost('sexe'),
            'pdp'                => $imageName,
            'verification_token' => bin2hex(random_bytes(16)),
            'is_verified'        => 0,
        ];
    
        if ($userModel->insert($userData)) {
            $verificationLink = base_url("verify/{$userData['verification_token']}");
    
            $subject = "Vérification de votre compte";
            $message = "Cliquez sur ce lien pour vérifier votre compte : $verificationLink";
            $email = \Config\Services::email();
            $email->setTo($userData['email']);
            $email->setSubject($subject);
            $email->setMessage($message);
    
            if ($email->send()) {
                return redirect()->to('/login')->with('success', 'Inscription réussie ! Un email de vérification a été envoyé.');
            } else {
                log_message('error', 'Failed to send verification email to ' . $userData['email']);
                log_message('error', 'Email send debug: ' . $email->printDebugger(['headers', 'subject', 'body']));
                return redirect()->back()->with('error', 'Erreur lors de l\'envoi de l\'email de vérification.');
            }
        } else {
            log_message('error', 'Database insertion failed: ' . json_encode($userModel->errors()));
            return redirect()->back()->with('error', 'Erreur lors de l\'inscription.');
        }
    }
    
  
    public function verify($token = null)
    {
        if ($token === null) {
            return redirect()->to('/login')->with('error', 'Aucun token fourni.');
        }
    
        log_message('debug', 'Token reçu: ' . $token);
    
        $userModel = new UserModel();
        $user = $userModel->where('verification_token', $token)->where('is_verified', 0)->first();
    
        log_message('debug', 'Token dans la base de données: ' . ($user ? $user['verification_token'] : 'Aucun utilisateur trouvé'));
    
        if (!$user) {
            return redirect()->to('/signup')->with('error', 'Token de vérification invalide ou compte déjà vérifié.');
        }
    
        if (isset($user['iduser'])) {
           
            $userModel->update($user['iduser'], ['is_verified' => 1, 'verification_token' => null]);
            return redirect()->to('/login')->with('success', 'Votre compte a été vérifié avec succès ! Vous pouvez maintenant vous connecter.');
        } else {
            return redirect()->to('/signup')->with('error', 'L\'utilisateur n\'a pas été trouvé.');
        }
    }
    
    
    
    
}

?>