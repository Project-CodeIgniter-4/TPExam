<?php

namespace App\Controllers;

use App\Models\MessagerieModel;
use CodeIgniter\Controller;

class ChatController extends Controller
{
    protected $messageModel;

    public function __construct()
    {
        $this->messageModel = new MessagerieModel();
    }
    public function envoyerMessage()
    {
        $userId = session()->get('iduser');
        $destinataireId = $this->request->getGet('destinataire');
    
        if ($userId && $destinataireId) {
            $infoDestinataire = $this->messageModel->getDestinataireInfo($destinataireId);
    
            $messages = $this->messageModel->getMessages($userId, $destinataireId, 'DESC');
    
            if ($this->request->getMethod() === 'post') {
                $message = $this->request->getPost('message');
                $media = $this->request->getFile('media');
    
                log_message('error', 'Message envoyé : ' . $message);
    
                if (!empty($message)) { 
                    $this->messageModel->sendMessage($userId, $destinataireId, $message, $media);
                } else {
                    log_message('error', 'Aucun message à envoyer');
                }
    
                return redirect()->to("/envoyerMessage?destinataire=$destinataireId");
            }
    
            return view('envoyerMessage', [
                'infoDestinataire' => $infoDestinataire,
                'messages' => $messages,
                'destinataire' => $destinataireId
            ]);
        }
    
       
    }
    


    public function deleteMessage()
    {
        $userId = session()->get('iduser');
        $messageId = $this->request->getGet('delete');
        $destinataireId = $this->request->getGet('destinataire');
    
        if ($userId && $messageId) {
            $deleted = $this->messageModel->deleteMessage($messageId, $userId);
    
            if ($deleted) {
                log_message('error', 'Message supprimé: ' . $messageId);
            } else {
                log_message('error', 'Erreur lors de la suppression du message: ' . $messageId);
            }
    
            return redirect()->to("/envoyerMessage?destinataire=$destinataireId");
        }
    
        return redirect()->to('/');
    }
    

}
