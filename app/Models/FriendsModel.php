<?php

namespace App\Models;

use CodeIgniter\Model;

class FriendsModel extends Model
{
    protected $table = 'friends';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'friend_id'];

    public function getFriends($userId)
    {
        return $this->db->table('friends f')
            ->select('u.iduser, u.name, u.lastname, u.pdp') 
            ->join('utilisateur u', 'f.friend_id = u.iduser', 'inner') 
            ->orWhere('f.user_id', $userId) 
            ->orWhere('f.friend_id', $userId)
            ->where('u.iduser !=', $userId) 
            ->get()
            ->getResultArray();
    }
    


    public function deleteFriends($userId, $friendIds)
    {
        $deletedCount = 0;
        foreach ($friendIds as $friendId) {
            $this->db->table('friends')
                ->where('user_id', $userId)
                ->where('friend_id', $friendId)
                ->delete();
            
            $this->db->table('friends')
                ->where('friend_id', $userId)
                ->where('user_id', $friendId)
                ->delete();
            
            $deletedCount++;
        }
        return $deletedCount;
    }
    public function checkFriendship($userId1, $userId2)
    {
        return $this->where("(user_id = $userId1 AND friend_id = $userId2) OR (user_id = $userId2 AND friend_id = $userId1)")
                    ->countAllResults() > 0;
    }

    public function getFriendRequestStatus($userId1, $userId2)
    {
        $query = $this->where("(user_id = $userId1 AND friend_id = $userId2) OR (user_id = $userId2 AND friend_id = $userId1)")->first();
        return $query['etat'] ?? null;

    }
    public function sendFriendRequest($userId1, $userId2)
{
    $existingRequest = $this->where('user_id', $userId1)
                            ->where('friend_id', $userId2)
                            ->first();

    if ($existingRequest) {
        return false; 
    }

    $data = [
        'user_id' => $userId1,
        'friend_id' => $userId2,
        'etat' => 'pending', 
        'created_at' => date('Y-m-d H:i:s')
    ];

    return $this->insert($data);
}


}
