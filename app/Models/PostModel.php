<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'post_id';
    protected $allowedFields = ['content', 'user_id', 'attachment'];

    public function getPosts($userId)
    {
        return $this->db->table($this->table)
        ->select('posts.*, u.name, u.lastname, u.pdp')
        ->join('utilisateur u', 'posts.user_id = u.iduser')
        ->where('posts.user_id', $userId)
        ->orWhereIn('posts.user_id', function ($builder) use ($userId) {
            $builder->select('friend_id')->from('friends')->where('user_id', $userId);
        })
        ->orderBy('posts.created_at', 'DESC')
        ->get()->getResultArray();
        
    }
    public function getUserPosts($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
?>
