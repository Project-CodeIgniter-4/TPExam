<?php

namespace App\Controllers;

use App\Models\PosteModel;
use CodeIgniter\Controller;

class PosteController extends Controller
{
    public function index()
    {
        $session = session();
        $userId = $session->get('iduser');
        
        if (!$userId) {
            return redirect()->to('/connexion');
        }
        
        $posteModel = new PosteModel();
        $data['posts'] = $posteModel->getUserPosts($userId);

        return view('poste_view', $data);
    }

    public function addPost()
    {
        $session = session();
        $userId = $session->get('iduser');

        if (!$userId) {
            return redirect()->to('/connexion');
        }

        $posteModel = new PosteModel();
        $content = $this->request->getPost('content');
        $attachment = '';

        if ($file = $this->request->getFile('image')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $attachment = $file->getRandomName();
                $file->move('images/', $attachment);
            }
        }

        if ($file = $this->request->getFile('video')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $attachment = $file->getRandomName();
                $file->move('videos/', $attachment);
            }
        }

        $posteModel->addPost($userId, $content, $attachment);
        return redirect()->to('/poste');
    }

    public function deletePost($postId)
    {
        $session = session();
        $userId = $session->get('iduser');

        if (!$userId) {
            return redirect()->to('/connexion');
        }

        $posteModel = new PosteModel();
        $posteModel->deletePost($postId, $userId);

        return redirect()->to('/poste');
    }
}
