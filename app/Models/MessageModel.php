<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table = 'messagerie';
    protected $primaryKey = 'id';
    protected $allowedFields = ['emetteur', 'destinataire', 'message', 'media', 'etat', 'created_at'];

    public function getMessages($userId, $destinataireId)
    {
        return $this->where('(
            (emetteur = ' . (int) $userId . ' AND destinataire = ' . (int) $destinataireId . ') 
            OR 
            (emetteur = ' . (int) $destinataireId . ' AND destinataire = ' . (int) $userId . ')
        )')
        ->orderBy('created_at', 'DESC')
        ->findAll();
    }
    
    public function sendMessage($emetteur, $destinataire, $message, $media)
    {
        return $this->insert([
            'emetteur' => $emetteur,
            'destinataire' => $destinataire,
            'message' => $message,
            'media' => $media,
            'etat' => 'envoyé',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function deleteMessage($messageId, $userId)
    {
        return $this->where('id', $messageId)->where('emetteur', $userId)->delete();
    }
    
    
}
