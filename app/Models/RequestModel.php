<?php
namespace App\Models;

use CodeIgniter\Model;

class RequestModel extends Model
{
    protected $table = 'messages';
    protected $allowedFields = ['emetteur', 'destinataire', 'date', 'etat'];

    public function isFriendRequestSent($emetteurId, $destinataireId)
    {
        return $this->where(['emetteur' => $emetteurId, 'destinataire' => $destinataireId, 'etat' => 'envoyé'])
                    ->countAllResults() > 0;
    }

    public function sendFriendRequest($emetteurId, $destinataireId)
    {
        return $this->insert([
            'emetteur' => $emetteurId,
            'destinataire' => $destinataireId,
            'date' => date('Y-m-d H:i:s'),
            'etat' => 'envoyé'
        ]);
    }
    public function getRequestStatus($emetteurId, $destinataireId)
{
    $request = $this->where('emetteur', $emetteurId)
                    ->where('destinataire', $destinataireId)
                    ->first(); 
    if ($request) {
        return $request['etat'];
    }
    
    return null;
}

}

?>