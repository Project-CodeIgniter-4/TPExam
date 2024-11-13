<?php

namespace App\Models;

use CodeIgniter\Model;

class UserupModel extends Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'iduser';
    protected $allowedFields = ['name', 'lastname', 'email', 'password', 'pdp'];
    
    public function getUserById($id)
    {
        return $this->where('iduser', $id)->first();
    }
    
    public function updateUser($id, $data)
    {
        return $this->update($id, $data);
    }
}
