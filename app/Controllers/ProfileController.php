<?php

namespace App\Controllers;

use App\Models\UserupModel;
use CodeIgniter\Controller;

class ProfileController extends Controller
{
    public function modifierProfil()
    {
        helper(['form']);
        $userModel = new UserupModel();
        $userId = session()->get('iduser');
        
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }
        
        $user = $userModel->getUserById($userId);
        
        return view('modifier_profil', ['user' => $user]);
    }
    
    public function updateProfile()
    {
        helper(['form', 'url']);
        $userModel = new UserupModel();
        $userId = session()->get('iduser');
        
        if (!$userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Veuillez vous connecter.']);
        }

        $field = $this->request->getPost('field');
        $newValue = $this->request->getPost('new_value');
        $currentPassword = $this->request->getPost('current_password');

        $user = $userModel->getUserById($userId);

        if (!password_verify($currentPassword, $user['password'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Mot de passe incorrect.']);
        }

        if ($field === 'password') {
            $newValue = password_hash($newValue, PASSWORD_BCRYPT);
        }

        $updateData = [$field => $newValue];

        if ($field === 'pdp') {
            $imageFile = $this->request->getFile('new_value');
            if ($imageFile->isValid() && !$imageFile->hasMoved()) {
                $newFileName = $userId . "_" . $imageFile->getRandomName();
                $imageFile->move(ROOTPATH . 'public/images/', $newFileName);

                $updateData['pdp'] = $newFileName;
            }
        }

        if ($userModel->updateUser($userId, $updateData)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Modification réussie.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Erreur lors de la modification.']);
        }
    }
}
