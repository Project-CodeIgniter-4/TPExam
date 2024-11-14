<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'iduser';
    protected $allowedFields = ['name', 'lastname', 'email', 'password', 'sexe', 'pdp', 'verification_token', 'reset_token', 'reset_expiry', 'is_verified'];

    public function checkEmailExists($email)
    {
        return $this->where('email', $email)->first();
    }
    public function getUserById($id)
    {
        return $this->where('iduser', $id)->first();
    }
    public function searchUsers($search, $userId)
    {
        return $this->where('iduser !=', $userId)
                    ->like('name', $search, 'after')
                    ->select('iduser, name, lastname, pdp')
                    ->findAll();
    }
    
}

?>