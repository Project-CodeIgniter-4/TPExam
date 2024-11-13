<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\FriendsModel;
use App\Models\PostModel;
use App\Models\RequestModel;
use CodeIgniter\Controller;

class ProfilesController extends Controller
{
 
    public function view($iduser)
    {
        $session = session();
        $currentUserId = $session->get('iduser');
        
        $userModel = new UserModel();
        $friendModel = new FriendsModel();
        $postsModel = new PostModel();
        $requestModel = new RequestModel();
    
        $user = $userModel->getUserById($iduser);
    
        if (!$user) {
            return redirect()->to('page-acceuil')->with('error', 'Utilisateur non trouvé');
        }
    
        $isFriend = $friendModel->checkFriendship($currentUserId, $iduser);
    
        $friendRequestStatus = $requestModel->getRequestStatus($currentUserId, $iduser);
    
        $posts = $postsModel->getUserPosts($iduser);
    
        return view('profile', [
            'user' => $user,
            'isFriend' => $isFriend,
            'friendRequestStatus' => $friendRequestStatus,
            'posts' => $posts
        ]);
    }
    
    
    public function sendFriendRequest($destinataireId)
    {
        $session = session();
        $emetteurId = $session->get('iduser');

        if (empty($destinataireId)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Le destinataire est invalide.']);
        }

        $requestModel = new RequestModel();

        if ($requestModel->isFriendRequestSent($emetteurId, $destinataireId)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Demande d\'ami déjà envoyée.']);
        }

        if ($requestModel->sendFriendRequest($emetteurId, $destinataireId)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Demande d\'ami envoyée avec succès.']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Erreur lors de l\'envoi de la demande d\'ami.']);
    }
}
