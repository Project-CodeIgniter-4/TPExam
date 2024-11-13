<?php

namespace App\Controllers;

use App\Models\HeaderModel;

class HeaderController extends BaseController
{
    public function index()
    {
        $data['friends'] = []; 

        return view('header_view', $data);
    }

    public function searchUser()
    {
        if ($this->request->getGet('search')) {
            $search = $this->request->getGet('search');
            $userId = session()->get('user_id'); 
            $userModel = new HeaderModel();
    
            log_message('debug', 'Recherche effectuée: ' . $search);
    
            $result = $userModel->searchUsers($search, $userId);
    
            return $this->response->setJSON($result);
        }
    
        return $this->response->setJSON([]);
    }
    
}
