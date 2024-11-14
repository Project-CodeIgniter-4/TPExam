<?php

namespace App\Models;

use CodeIgniter\Model;

class FriendModel extends Model
{
    protected $table = 'friends'; 
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'friend_id', 'status'];

    public function getFriends($userId)
    {
        return $this->db->table($this->table)
            ->select('*')
            ->where('user_id', $userId)
            ->orWhere('friend_id', $userId)
            ->get()
            ->getResultArray();
    }

    
    public function addFriend($userId, $friendId)
    {
        $data = [
            'user_id' => $userId,
            'friend_id' => $friendId,
            'status' => 'pending' 
        ];

        return $this->insert($data);
    }
    public function addsFriend($userId, $friendId)
    {
        $data = [
            ['user_id' => $userId, 'friend_id' => $friendId],
            ['user_id' => $friendId, 'friend_id' => $userId],
        ];
        
        return $this->insertBatch($data);
    }

    public function removeFriend($userId, $friendId)
    {
        return $this->db->table($this->table)
            ->where('user_id', $userId)
            ->where('friend_id', $friendId)
            ->delete();
    }
}
