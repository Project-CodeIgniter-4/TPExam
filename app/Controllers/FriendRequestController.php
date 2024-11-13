<?php
namespace App\Controllers;

use App\Models\FriendRequestModel;
use CodeIgniter\Controller;

class FriendRequestController extends Controller
{
    public function index()
    {
        $session = session();
        $userId = $session->get('iduser');
        
        if (!$userId) {
            return redirect()->to('/login');
        }

        $friendRequestModel = new FriendRequestModel();
        $friendRequests = $friendRequestModel->getFriendRequests($userId);

        $search = $this->request->getVar('search');
        $searchResults = $search ? $friendRequestModel->searchUsers($search, $userId) : null;

        return view('listeamis', [  
            'friendRequests' => $friendRequests,
            'searchResults' => $searchResults
        ]);
    }

    public function accept($requestId)
    {
        $session = session();
        $userId = $session->get('iduser');

        if (!$userId || !$requestId) {
            return redirect()->to('listeamis')->with('error', 'Invalid request');
        }

        $friendRequestModel = new FriendRequestModel();

        if ($friendRequestModel->acceptFriendRequest($requestId, $userId)) {
            return redirect()->to('listeamis')->with('success', 'Friend request accepted');
        } else {
            return redirect()->to('listeamis')->with('error', 'Failed to accept the friend request');
        }
    }

    public function reject($emetteurId)
    {
        $session = session();
        $userId = $session->get('iduser');

        if (!$userId || !$emetteurId) {
            return redirect()->to('listeamis')->with('error', 'Invalid request');
        }

        $friendRequestModel = new FriendRequestModel();
        
        if ($friendRequestModel->rejectFriendRequest($emetteurId, $userId)) {
            return redirect()->to('listeamis')->with('success', 'Friend request rejected');
        } else {
            return redirect()->to('listeamis')->with('error', 'Failed to reject the friend request');
        }
    }
}

?>