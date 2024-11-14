<link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
</head>
<body>
    <div class="left-section">TextMe</div>
    <div class="login-form">
        <h2>Connexion</h2>

        <?= session()->getFlashdata('error') ?>

        <form action="<?= base_url('login/authenticate') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <input type="password" name="mdp" id="mdp" placeholder="Mot de passe" required>
            <button type="submit">Connexion</button>
        </form>

        <div style="text-align: center; margin-top: 15px;">
            <a href="<?= base_url('forgot-password') ?>" style="color: #bbb; text-decoration: none;">Mot de passe oublié ?</a>
            <br>
            <a href="<?= base_url('signup') ?>" style="color: #bbb; text-decoration: none;">Pas encore inscrit ? Créez un compte</a>
        </div>
    </div>
</body>
</html>