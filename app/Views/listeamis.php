<link rel="stylesheet" href="<?= base_url('assets/css/listeamis.css') ?>">
<?= view('header') ?>
<h2>Demandes d'amis</h2>

<?php if ($searchResults): ?>
    <h3>Résultats de recherche</h3>
    <ul>
        <?php foreach ($searchResults as $user): ?>
            <li><?= htmlspecialchars($user['name'] . ' ' . $user['lastname']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($friendRequests): ?>
    <table>
        <tr>
            <th>Photo</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Sexe</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($friendRequests as $request): ?>
            <tr>
                <td><img src="<?= base_url('images/' . $request['pdp']) ?>" alt="Photo de profil" width="50" height="50"></td>
                <td><?= htmlspecialchars($request['name']) ?></td>
                <td><?= htmlspecialchars($request['lastname']) ?></td>
                <td><?= htmlspecialchars($request['sexe']) ?></td>
                <td>
                    <a href="<?= base_url('friendrequest/accept/' . $request['id']) ?>">Accepter</a> |
                    <a href="<?= base_url('friendrequest/reject/' . $request['emetteur']) ?>">Refuser</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Aucune demande d'ami.</p>
<?php endif; ?>
