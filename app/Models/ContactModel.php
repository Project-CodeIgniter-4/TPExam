<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactModel extends Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'iduser';
    protected $allowedFields = ['name', 'lastname', 'email', 'password', 'role', 'pdp'];

    public function getFriends($userId)
    {
        $builder = $this->db->table('utilisateur u');
        $builder->join('friends f', 'f.friend_id = u.iduser OR f.user_id = u.iduser');
        $builder->where('f.user_id', $userId);
        return $builder->get()->getResultArray();
    }

    public function getMessages($userId, $destinataireId)
    {
        $builder = $this->db->table('messagerie');
        $builder->where("(emetteur = $userId AND destinataire = $destinataireId) OR (emetteur = $destinataireId AND destinataire = $userId)");
        return $builder->get()->getResultArray();
    }

    public function saveMessage($data)
    {
        return $this->db->table('messagerie')->insert($data);
    }

    public function getUserInfo($userId)
    {
        return $this->find($userId);
    }
}
