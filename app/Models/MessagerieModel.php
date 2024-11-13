<?php

namespace App\Models;

use CodeIgniter\Model;

class MessagerieModel extends Model
{
    protected $table = 'messagerie';
    protected $primaryKey = 'id';
    protected $allowedFields = ['emetteur', 'destinataire', 'message', 'media', 'etat', 'created_at'];

    public function getDestinataireInfo($destinataireId)
    {
        $db = \Config\Database::connect();
        return $db->table('utilisateur')
                  ->select('name, pdp')
                  ->where('iduser', $destinataireId)
                  ->get()
                  ->getRowArray();
    }

   public function getMessages($userId, $destinataireId, $order = 'ASC')
{
    $builder = $this->db->table('messagerie');
    $builder->select('*')
            ->where('(emetteur = ' . $userId . ' AND destinataire = ' . $destinataireId . ') OR (emetteur = ' . $destinataireId . ' AND destinataire = ' . $userId . ')')
            ->orderBy('created_at', $order);
    
    $query = $builder->get();
    return $query->getResultArray();
}


public function sendMessage($userId, $destinataireId, $message, $media = null)
{
    $data = [
        'emetteur' => $userId,
        'destinataire' => $destinataireId,
        'message' => $message,
        'media' => null, 
        'etat' => 'envoyé',
        'created_at' => date('Y-m-d H:i:s')
    ];

    if ($media && $media->isValid()) {
        $fileName = $media->getRandomName();
        $media->move(WRITEPATH . 'uploads/', $fileName);
        $data['media'] = $fileName;
    }

    return $this->insert($data);
}



    public function deleteMessage($messageId, $userId)
    {
        return $this->where('id', $messageId)->where('emetteur', $userId)->delete();
    }
}
