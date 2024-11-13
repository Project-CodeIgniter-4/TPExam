<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('forgot_password');
    }

    public function sendResetLink()
    {
        helper(['form', 'url']);
        $validation = \Config\Services::validation();
        $userModel = new UserModel();

       
        $validation->setRules([
            'email' => 'required|valid_email',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }

        $email = $this->request->getPost('email');

        $user = $userModel->where('email', $email)->first();

        if ($user) {
            $token = bin2hex(random_bytes(50));
            $expiry = time() + 3600;
            $userModel->update($user['iduser'], [
                'reset_token' => $token,
                'reset_expiry' => $expiry
            ]);

            $resetLink = base_url("reset-password/{$token}");

            $subject = "Réinitialisation de mot de passe";
            $message = "Cliquez sur ce lien pour réinitialiser votre mot de passe : $resetLink";
            $emailService = \Config\Services::email();
            $emailService->setTo($email);
            $emailService->setSubject($subject);
            $emailService->setMessage($message);

            if ($emailService->send()) {
                return redirect()->to('/login')->with('success', 'Un lien de réinitialisation a été envoyé à votre email.');
            } else {
                return redirect()->back()->with('error', 'Erreur lors de l\'envoi de l\'email.');
            }
        } else {
            return redirect()->back()->with('error', 'Cet email n\'existe pas dans notre base de données.');
        }
    }

    public function resetPassword($token = null)
    {
        if (!$token) {
            return redirect()->to('/login')->with('error', 'Token manquant.');
        }
    
        $userModel = new UserModel();
        $user = $userModel->where('reset_token', $token)
                          ->where('reset_expiry >', time())
                          ->first();
    
        if (!$user) {
            return redirect()->to('/login')->with('error', 'Le lien de réinitialisation est invalide ou expiré.');
        }
    
        return view('reset_password', ['token' => $token]);
    }
    
    

    public function updatePassword()
    {
        helper(['form', 'url']);
        $validation = \Config\Services::validation();

        $validation->setRules([
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }

        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('reset_token', $token)
                          ->where('reset_expiry >', time())
                          ->first();

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Le lien de réinitialisation est invalide ou expiré.');
        }

        $userModel->update($user['iduser'], [
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'reset_token' => null,
            'reset_expiry' => null,
        ]);

        return redirect()->to('/login')->with('success', 'Votre mot de passe a été réinitialisé avec succès.');
    }
}
