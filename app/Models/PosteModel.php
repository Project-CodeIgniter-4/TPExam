<?php

namespace App\Models;

use CodeIgniter\Model;

class PosteModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'post_id';
    protected $allowedFields = ['user_id', 'content', 'attachment', 'created_at'];

    public function getUserPosts($userId)
    {
        return $this->select('posts.*, utilisateur.name, utilisateur.lastname, utilisateur.pdp')
                    ->join('utilisateur', 'utilisateur.iduser = posts.user_id')
                    ->where('posts.user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function addPost($userId, $content, $attachment)
    {
        return $this->insert([
            'user_id' => $userId,
            'content' => $content,
            'attachment' => $attachment,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function deletePost($postId, $userId)
    {
        $db = \Config\Database::connect();
        $db->table('commentaires')->where('post_id', $postId)->delete();

        return $this->where('post_id', $postId)->where('user_id', $userId)->delete();
    }
}
