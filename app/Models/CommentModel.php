<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'commentaires';
    protected $primaryKey = 'comment_id';
    protected $allowedFields = ['post_id', 'user_id', 'content'];

    public function getComments($postId)
    {
        return $this->db->table('commentaires c')
        ->select('c.*, u.name, u.lastname')
        ->join('utilisateur u', 'c.user_id = u.iduser')
        ->where('c.post_id', $postId)
        ->orderBy('c.created_at', 'DESC')
        ->get()->getResultArray();
    
    }
}
?>
