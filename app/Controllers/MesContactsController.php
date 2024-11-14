<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\FriendsModel;
use CodeIgniter\Controller;

class MesContactsController extends Controller
{
    public function index()
    {
        $session = session();
        $userId = $session->get('iduser');

        if (!$userId) {
            return redirect()->to('login')->with('error', 'Veuillez vous connecter.');
        }

        $friendModel = new FriendsModel();
        $friends = $friendModel->getFriends($userId);
        $friends = array_filter($friends, function($friend) use ($userId) {
            return $friend['iduser'] != $userId;
        });

        return view('mescontacts', ['friends' => $friends]);
    }

    public function deleteFriends()
    {
        $session = session();
        $userId = $session->get('iduser');
        if (!$userId || !isset($_POST['checked_friends'])) {
            return redirect()->to('Mescontacts')->with('error', 'Aucun ami sélectionné.');
        }

        $friendModel = new FriendsModel();
        $checkedFriends = $_POST['checked_friends'];

        $deletedCount = $friendModel->deleteFriends($userId, $checkedFriends);

        if ($deletedCount > 0) {
            return redirect()->to('Mescontacts')->with('success', "$deletedCount amis supprimés.");
        } else {
            return redirect()->to('Mescontacts')->with('error', 'Aucun ami n\'a été supprimé.');
        }
    }
}
?>
