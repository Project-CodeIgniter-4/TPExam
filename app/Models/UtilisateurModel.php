<?php
namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'iduser';
    protected $allowedFields = ['name', 'lastname', 'email', 'password', 'role', 'pdp'];

    public function getUserContacts($userId)
    {
        return $this->db->table('utilisateur u')
                        ->join('friends f', 'u.iduser = f.friend_id OR u.iduser = f.user_id')
                        ->where('f.user_id', $userId)
                        ->orWhere('f.friend_id', $userId)
                        ->where('u.iduser !=', $userId)
                        ->get()
                        ->getResultArray();
    }
    public function getUtilisateurById($id)
    {
        return $this->where('iduser', $id)->first();
    }
}

?>