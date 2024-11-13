<?php
namespace App\Models;

use CodeIgniter\Model;

class FriendRequestModel extends Model
{
    protected $table = 'messages';
    protected $allowedFields = ['emetteur', 'destinataire', 'date', 'etat'];
    
    public function getFriendRequests($userId)
    {
        return $this->select('messages.id, utilisateur.iduser, utilisateur.name, utilisateur.lastname, utilisateur.sexe, utilisateur.pdp, messages.emetteur')
                    ->join('utilisateur', 'messages.emetteur = utilisateur.iduser')
                    ->where('messages.destinataire', $userId)
                    ->findAll();
    }

    public function searchUsers($search, $userId)
    {
        return $this->db->table('utilisateur')
                        ->like('name', $search)
                        ->where('iduser !=', $userId)
                        ->get()
                        ->getResultArray();
    }

    public function acceptFriendRequest($requestId, $userId)
    {
        $request = $this->where('id', $requestId)
                        ->where('destinataire', $userId)
                        ->where('etat', 'envoyé')
                        ->first();

        if ($request) {
            $friendModel = new \App\Models\FriendModel();
            $friendModel->addsFriend($userId, $request['emetteur']);
            
            $this->delete($requestId);

            return true;
        }

        return false;
    }

    public function rejectFriendRequest($emetteurId, $destinataireId)
    {
        return $this->where('emetteur', $emetteurId)
                    ->where('destinataire', $destinataireId)
                    ->delete();
    }
}

?>