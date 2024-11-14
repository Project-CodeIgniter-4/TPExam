
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe</title>

    <link rel="stylesheet" href="<?= base_url('assets/css/reset.css') ?>">
</head>
<body>
    <div class="left-section">TextMe</div>
    <div class="login-form">
        <h2>Réinitialiser votre mot de passe</h2>

        <?= session()->getFlashdata('error') ?>
        <?= session()->getFlashdata('success') ?>

        <form action="<?= base_url('reset-password/update') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="token" value="<?= esc($token) ?>">
            <input type="password" name="password" placeholder="Nouveau mot de passe" required>
            <input type="password" name="confirm_password" placeholder="Confirmez le mot de passe" required>
            <button type="submit">Réinitialiser</button>
        </form>
    </div>
</body>
</html>
