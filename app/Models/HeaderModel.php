<?php

namespace App\Models;

use CodeIgniter\Model;

class HeaderModel extends Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'iduser';
    protected $allowedFields = ['name', 'lastname', 'pdp', 'email']; 

    public function searchUsers($search, $userId)
    {
        return $this->like('name', $search)
            ->where('iduser !=', $userId)  
            ->findAll();
    }
}
