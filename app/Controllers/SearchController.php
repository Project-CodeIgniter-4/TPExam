<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class SearchController extends Controller
{
    public function searchUser()
    {
        
    $session = session();
    $userId = $session->get('iduser');
    log_message('debug', 'ID utilisateur de la session: ' . $userId);

        $search = $this->request->getGet('search');
        
        if ($search && $userId) {
            $userModel = new UserModel();
            $users = $userModel->searchUsers($search, $userId);
            return $this->response->setJSON($users);
        }

        return $this->response->setJSON([]);
    }
}
