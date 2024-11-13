<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le profil</title>
    
<link rel="stylesheet" href="<?= base_url('assets/css/modifier.css') ?>">
    <script>
        function showField(field) {
            document.getElementById('field').value = field;
            document.getElementById('fieldName').textContent = field.charAt(0).toUpperCase() + field.slice(1);
            document.getElementById('newValue').type = (field === 'password') ? 'password' : (field === 'pdp' ? 'file' : 'text');
            document.getElementById('form').style.display = 'block';
        }

        function updateProfile(event) {
            event.preventDefault();
            const formData = new FormData(document.getElementById('form'));

            fetch("<?= base_url('profile/updateProfile') ?>", {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const msgBox = document.getElementById('msgBox');
                msgBox.innerText = data.message;
                msgBox.style.backgroundColor = data.success ? 'lightgreen' : 'lightcoral';
                msgBox.style.display = 'block';
            })
            .catch(error => {
                const msgBox = document.getElementById('msgBox');
                msgBox.innerText = "Erreur de communication avec le serveur.";
                msgBox.style.backgroundColor = 'lightcoral';
                msgBox.style.display = 'block';
            });
        }
    </script>
</head>
<body>
<?= view('header') ?>
<div class="main-container">
    <div class="sidebar">
        <h2>Modifier Profil</h2>
        <a href="#name" onclick="showField('name'); return false;">Nom</a>
        <a href="#lastname" onclick="showField('lastname'); return false;">Prénom</a>
        <a href="#email" onclick="showField('email'); return false;">Email</a>
        <a href="#password" onclick="showField('password'); return false;">Mot de passe</a>
        <a href="#pdp" onclick="showField('pdp'); return false;">Photo de profil</a>
    </div>

    <div class="content">
        
        <div id="msgBox" style="display: none;"></div>
        
        <form id="form" method="post" enctype="multipart/form-data" style="display: none;">
            <input type="hidden" name="field" id="field">
            <label for="newValue">Nouveau <span id="fieldName"></span> :</label>
            <input type="text" name="new_value" id="newValue" required>
            <label for="current_password">Mot de passe actuel :</label>
            <input type="password" name="current_password" required>
            <button type="button" onclick="updateProfile(event)">Confirmer la modification</button>
        </form>
    </div>
</div>
</body>
</html>
