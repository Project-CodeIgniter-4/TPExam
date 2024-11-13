<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Contacts</title>
</head>
<body>
<?= view('header') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/mescontacts.css') ?>">
<h2>Mes Contacts</h2>

<?php if (session()->getFlashdata('success')): ?>
    <p style="color: green;"><?= session()->getFlashdata('success') ?></p>
<?php elseif (session()->getFlashdata('error')): ?>
    <p style="color: red;"><?= session()->getFlashdata('error') ?></p>
<?php endif; ?>

<form action="<?= base_url('Mescontacts/deleteFriends') ?>" method="post" onsubmit="return confirmDeletion();">
    <?php if ($friends && count($friends) > 0): ?>
        <table>
            <?php foreach ($friends as $friend): ?>
                <tr>
                    <td><input type="checkbox" name="checked_friends[]" value="<?= esc($friend['iduser']) ?>"></td>
                    <td><img src="<?= base_url('images/' . esc($friend['pdp'])) ?>" alt="Photo de profil"></td>
                    <td><?= esc($friend['name']) ?></td>
                    <td><?= esc($friend['lastname']) ?></td>
                  
                </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit" name="delete" value="delete">Supprimer les amis sélectionnés</button>
    <?php else: ?>
        <p>Vous n'avez aucun contact.</p>
    <?php endif; ?>
</form>
<script src="<?= base_url('assets/js/mescontacts.js') ?>"></script>

</body>
</html>