<header>
    <div class="logo">B.T.S</div>
    <nav>
        <a href="<?= base_url('pageacceuilbts') ?>">Acceuil</a>
        <a href="<?= base_url('listeamis') ?>">Ma liste d'amis</a>
        <a href="<?= base_url('poste') ?>">Poste</a>
        <a href="<?= base_url('Mescontacts') ?>">Contact</a>
        <a href="<?= base_url('deconnexion') ?>">Déconnexion</a>
    </nav>
</header>

<div class="chat-container">
    <?php if ($infoDestinataire): ?>
        <div class="destinataire-info">
            <img src="<?= base_url('uploads/' . esc($infoDestinataire['pdp'])) ?>" alt="Photo de profil">
            <h3><?= esc($infoDestinataire['name']) ?></h3>
        </div>
    <?php endif; ?>

    <div class="messages-history">
        <?php foreach ($messages as $msg): ?>
            <div class="<?= $msg['emetteur'] == session()->get('iduser') ? 'message-envoye' : 'message-recu' ?>" oncontextmenu="showContextMenu(event, <?= $msg['id'] ?>)">
                <?= esc($msg['message']) ?>
                <?php if ($msg['media']): ?>
                    <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $msg['media'])): ?>
                        <img src="<?= base_url('uploads/' . esc($msg['media'])) ?>" alt="Image envoyée">
                    <?php elseif (preg_match('/\.(mp4|mov|avi)$/i', $msg['media'])): ?>
                        <video controls>
                            <source src="<?= base_url('uploads/' . esc($msg['media'])) ?>" type="video/mp4">
                            Votre navigateur ne supporte pas la vidéo.
                        </video>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <form action="<?= base_url('envoyerMessage') ?>" method="POST" enctype="multipart/form-data">
    <textarea name="message" placeholder="Écrire un message..."></textarea>
    <input type="file" name="media">
    <input type="hidden" name="destinataire" value="<?= esc($destinataire) ?>"> 
    <input type="submit" value="Envoyer">
</form>

</div>

<div id="contextMenu" style="display:none; position:absolute; background-color:white; border:1px solid #ccc; padding:10px; z-index:1000;">
    <button onclick="deleteMessage()">Supprimer</button>
</div>

<script>
    function showContextMenu(event, messageId) {
        event.preventDefault();
        const menu = document.getElementById('contextMenu');
        menu.style.display = 'block';
        menu.style.left = event.pageX + 'px';
        menu.style.top = event.pageY + 'px';
        menu.setAttribute('data-message-id', messageId);
    }

    function hideContextMenu() {
        const menu = document.getElementById('contextMenu');
        menu.style.display = 'none';
    }

    function deleteMessage() {
    const messageId = document.getElementById('contextMenu').getAttribute('data-message-id');
    const destinataireId = '<?= esc($destinataire) ?>'; 
    console.log('Suppression du message ID:', messageId); 
    window.location.href = '/envoyerMessage/delete?destinataire=' + destinataireId + '&delete=' + messageId;
}



    document.addEventListener('click', hideContextMenu);
</script>


<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            padding: 20px;
            position: fixed;
            width: 98%;
            top: 0;
            left: 0;
            z-index: 999;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            color: #f4f4f4;
        }

        nav {
            display: flex;
            gap: 20px;
        }

        nav a, .deconnexion-btn {
            text-decoration: none;
            color: white;
            font-size: 16px;
            padding: 10px 15px;
            background-color: #555;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav a:hover, .deconnexion-btn:hover {
            background-color: #777;
        }

        .chat-container {
            width: 50%;
            margin: 100px auto;
            background-color: #fff;
            padding: 27px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .destinataire-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .destinataire-info img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .messages-history {
            margin-bottom: 20px;
            overflow: auto;
            max-height: 300px;
        }

        .message-envoye, .message-recu {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 10px;
        }

        .message-envoye {
            background-color: #dcf8c6;
            align-self: flex-end;
        }

        .message-recu {
            background-color: #eaeaea;
        }

        textarea {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
        }

        input[type="submit"], button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover, button:hover {
            background-color: #45a049;
        }

        .message-recu img, .message-envoye img,
        .message-recu video, .message-envoye video {
            max-width: 200px; /* Taille maximale pour les images et vidéos */
            height: auto;
            margin-top: 10px;
            border-radius: 10px;
        }
    </style>