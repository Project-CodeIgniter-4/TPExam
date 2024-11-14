<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'iduser';
    protected $allowedFields = ['name', 'email', 'password', 'role'];

    public function getFriends($userId)
    {
        return $this->db->table('utilisateur u')
            ->select('u.iduser, u.name, u.lastname, u.pdp')
            ->whereIn('u.iduser', function ($builder) use ($userId) {
                $builder->select('friend_id')->from('friends')->where('user_id', $userId);
            })
            ->get()->getResultArray();
    }
}
?>
