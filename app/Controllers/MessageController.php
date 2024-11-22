<?php

namespace App\Controllers;

use App\Models\MessageModel;
use App\Models\UserModel;

class MessageController extends BaseController
{
    public function index()
    {
        $userId = session()->get('iduser');

        $destinataireId = $this->request->getVar('destinataire');

        if (!$userId || !$destinataireId) {
            return redirect()->to('/')->with('error', 'Utilisateur ou destinataire invalide.');
        }

        $messageModel = new MessageModel();
        $userModel = new UserModel();

        $destinataire = $userModel->find($destinataireId);

        $messages = $messageModel->getMessages($userId, $destinataireId);

        return view('envoyerMessage', [
            'userId' => $userId,
            'destinataire' => $destinataire,
            'messages' => $messages
        ]);
    }

    public function sendMessage()
{
    if ($this->request->getMethod() === 'post') {
        $userId = session()->get('iduser');
        $destinataireId = $this->request->getVar('destinataire');
        $message = $this->request->getVar('message');
        $media = $this->request->getFile('media');

        if (empty($message) && (!$media || !$media->isValid())) {
            return redirect()->back()->with('error', 'Message ou média manquant.');
        }

        $mediaFile = null;
        if ($media && $media->isValid()) {
            $fileExtension = $media->getClientExtension();
            
           
            if (in_array(strtolower($fileExtension), ['mp4', 'webm', 'ogg'])) {
             
                $mediaName = $media->getRandomName();
            } else {
           
                $mediaName = $media->getName();
            }

           
            $media->move('public/uploads', $mediaName);
            $mediaFile = $mediaName;
        }

        $messageModel = new MessageModel();
        $messageModel->sendMessage($userId, $destinataireId, $message, $mediaFile);

        return redirect()->to(current_url())->with('success', 'Message envoyé.');
    }

    return redirect()->to('/')->with('error', 'Méthode non autorisée.');
}

    
    

public function deleteMessage($messageId)
{
    $userId = session()->get('iduser');
    $messageModel = new MessageModel();


    $message = $messageModel->find($messageId);
    if (!$message) {
        return $this->response->setStatusCode(404)->setBody('Message introuvable');
    }
    
    if ($message['emetteur'] != $userId) {
        return $this->response->setStatusCode(403)->setBody('Vous n\'êtes pas autorisé à supprimer ce message');
    }
    
  
    if ($messageModel->delete($messageId)) {
        return $this->response->setStatusCode(200)->setBody('Message supprimé');
    }
    
    return $this->response->setStatusCode(500)->setBody('Erreur lors de la suppression du message');
}

    
}
