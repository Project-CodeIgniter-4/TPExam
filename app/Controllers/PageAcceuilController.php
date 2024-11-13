<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CommentModel;
use App\Models\UsersModel;
use App\Models\UtilisateursModel;
use App\Models\ContactModel;
use CodeIgniter\Controller;

class PageAcceuilController extends Controller
{
    public function index()
    {
        $session = session();
        $userId = $session->get('iduser');
        
        $postModel = new PostModel();
        $posts = $postModel->getPosts($userId);
        
        $userModel = new UtilisateursModel();
        $friends = $userModel->getFriends($userId);
    
        $friends = array_filter($friends, function($friend) use ($userId) {
            return $friend['iduser'] != $userId;
        });
        
        return view('page-acceuil', [
            'posts' => $posts,
            'friends' => $friends,
            'userId' => $userId
        ]);
    }
    

    public function createPost()
    {
        $session = session();
        $userId = $session->get('iduser');
        
        $postModel = new PostModel();
        $postData = [
            'content' => $this->request->getPost('content'),
            'user_id' => $userId,
            'attachment' => $this->uploadAttachment()
        ];
        
        $postModel->save($postData);
        return redirect()->to('/page-acceuil');
    }

    public function addComment()
    {
        $session = session();
        $userId = $session->get('iduser');
        
        $commentModel = new CommentModel();
        $commentData = [
            'post_id' => $this->request->getPost('post_id'),
            'user_id' => $userId,
            'content' => $this->request->getPost('comment')
        ];
        
        $commentModel->save($commentData);
        return redirect()->to('/page-acceuil');
    }

    private function uploadAttachment()
    {
        $file = $this->request->getFile('attachment');
    
        if ($file->isValid()) {
            $extension = $file->getClientExtension();
            
            $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
            $allowedVideoExtensions = ['mp4', 'avi', 'mov', 'mkv', 'webm', 'flv'];
    
            $filename = time() . '_' . $file->getName();
            $path = 'images/' . $filename;
            
            $file->move(ROOTPATH . 'public/images', $filename);
            
            if (in_array($extension, array_merge($allowedImageExtensions, $allowedVideoExtensions))) {
                return $filename;
            }
        }
    
        return null; 
    }
    
   public function sendMessage()
{
    $session = session();
    $userId = $session->get('iduser');
    $destinataireId = $this->request->getPost('destinataire_id');
    $messageContent = $this->request->getPost('message');
    $file = $this->request->getFile('media');
    
    $contactModel = new ContactModel();
    
    $media = null;
    if ($file && $file->isValid()) {
        $media = $file->getName();
  
        $file->move(ROOTPATH . 'public/uploads');
    }

    $data = [
        'emetteur' => $userId,
        'destinataire' => $destinataireId,
        'message' => $messageContent,
        'media' => $media,
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    $contactModel->saveMessage($data);

    return redirect()->to('/page-acceuil');
}

    public function showMessages($destinataireId)
    {
        $session = session();
        $userId = $session->get('iduser');
        
        $contactModel = new ContactModel();
        
        $messages = $contactModel->getMessages($userId, $destinataireId);
        
        $recipientInfo = $contactModel->getUserInfo($destinataireId);

        return view('chat', [
            'messages' => $messages,
            'recipientInfo' => $recipientInfo,
            'userId' => $userId
        ]);
    }
    
    
}
?>