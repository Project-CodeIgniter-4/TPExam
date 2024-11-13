<?php

namespace App\Models;
use CodeIgniter\Model;

class UtilisateursModel extends Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'iduser';
    protected $allowedFields = ['name', 'lastname', 'email', 'password', 'pdp', 'role'];

    public function getFriends($userId)
    {
        return $this->db->table('friends')
            ->select('utilisateur.iduser, utilisateur.name, utilisateur.lastname, utilisateur.pdp')
            ->join('utilisateur', 'utilisateur.iduser = friends.friend_id')
            ->where('friends.user_id', $userId)
            ->orWhere('friends.friend_id', $userId)
            ->get()
            ->getResultArray();
    }
}
