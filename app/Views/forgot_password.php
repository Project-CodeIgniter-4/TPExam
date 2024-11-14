<link rel="stylesheet" href="<?= base_url('assets/css/forgot.css') ?>">
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
</head>
<body>
    <div class="left-section">TextMe</div>
    <div class="login-form">
        <h2>Mot de passe oublié</h2>

        <?= session()->getFlashdata('error') ?>
        <?= session()->getFlashdata('success') ?>

        <form action="<?= base_url('forgot-password/send-reset-link') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="email" name="email" placeholder="Entrez votre email" required>
            <button type="submit" name="submit">Envoyer</button>
        </form>

        <div class="lien">
            <a href="<?= base_url('login') ?>">Retour à la connexion</a>
        </div>
    </div>
</body>
</html>
