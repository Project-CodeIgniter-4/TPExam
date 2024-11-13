<?php
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->get('signup', 'SignupController::index');
$routes->post('signup/register', 'SignupController::register');
$routes->get('verify/(:any)', 'SignupController::verify/$1');

$routes->get('login', 'LoginController::index');
$routes->post('login/authenticate', 'LoginController::authenticate');
$routes->match(['get', 'post'], 'forgot-password', 'ForgotPasswordController::index');
$routes->post('forgot-password/send-reset-link', 'ForgotPasswordController::sendResetLink');
$routes->get('reset-password/(:any)', 'ForgotPasswordController::resetPassword/$1');
$routes->post('reset-password/update', 'ForgotPasswordController::updatePassword');

$routes->get('/page-acceuil', 'PageAcceuilController::index');
$routes->post('/page-acceuil/createPost', 'PageAcceuilController::createPost');
$routes->post('/page-acceuil/addComment', 'PageAcceuilController::addComment');
$routes->get('/page-acceuil/showMessages/(:num)', 'PageAcceuilController::showMessages/$1');
$routes->post('/page-acceuil/sendMessage', 'PageAcceuilController::sendMessage');

$routes->get('poste', 'PosteController::index');
$routes->post('PosteController/addPost', 'PosteController::addPost');
$routes->post('PosteController/deletePost/(:num)', 'PosteController::deletePost/$1');

$routes->get('deconnexion', 'AuthController::logout');

$routes->get('modifier_profil', 'ProfileController::modifierProfil');
$routes->post('profile/updateProfile', 'ProfileController::updateProfile');

$routes->get('Mescontacts', 'MesContactsController::index');
$routes->post('Mescontacts/deleteFriends', 'MesContactsController::deleteFriends');

$routes->post('messages/sendMessage', 'MessageController::sendMessage');
$routes->get('messages/delete/(:num)', 'MessageController::deleteMessage/$1');
$routes->post('/messages/deleteMessage/(:num)', 'MessageController::deleteMessage/$1');

$routes->get('searchUser', 'SearchController::searchUser');

$routes->get('profil/(:num)', 'ProfilesController::view/$1');

$routes->post('profiles/sendFriendRequest', 'ProfilesController::sendFriendRequest');
$routes->post('profiles/sendFriendRequest/(:num)', 'ProfilesController::sendFriendRequest/$1');
$routes->get('listeamis', 'FriendRequestController::index');
$routes->get('friendrequest/accept/(:num)', 'FriendRequestController::accept/$1');
$routes->get('friendrequest/reject/(:num)', 'FriendRequestController::reject/$1');
$routes->post('/messages/deleteMessage/(:num)', 'MessageController::deleteMessage/$1');

$routes->GET('envoyerMessage', 'ChatController::envoyerMessage');
$routes->POST('envoyerMessage', 'ChatController::envoyerMessage');
$routes->POST('envoyerMessage/delete', 'ChatController::deleteMessage');

$routes->post('page-acceuil/deleteMessage/(:num)', 'MessageController::deleteMessage/$1');
$routes->post('page-acceuil/deleteMessage/(:num)', 'MessageController::deleteMessage/$1');
