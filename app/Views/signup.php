
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
<link rel="stylesheet" href="<?= base_url('assets/css/signup.css') ?>">
    <title>Inscription</title>
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
</head>
<body>
    <div class="left-section">TextMe</div>
    <div class="container">
        <h2>Inscription</h2>
        <?= session()->getFlashdata('error') ?>
        <?= session()->getFlashdata('success') ?>
        <form action="<?= base_url('signup/register') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" required>

            <label for="lastname">Prénom :</label>
            <input type="text" id="lastname" name="lastname" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <label for="sexe">Sexe :</label>
            <select id="sexe" name="sexe" required>
                <option value="H">Homme</option>
                <option value="F">Femme</option>
                <option value="O">Autre</option>
            </select>

            <label for="pdp">Photo de profil :</label>
            <input type="file" id="pdp" name="pdp" accept="images/*" required>

            <button type="submit">S'inscrire</button>
        </form>
    </div>
</body>
</html>