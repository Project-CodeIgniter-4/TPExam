<div class="chat-container">
<link rel="stylesheet" href="<?= base_url('assets/css/chat.css') ?>">

    <div class="chat-header">
    <div class="chat-header">
   
    <img src="<?= base_url('images/' . htmlspecialchars($recipientInfo['pdp'])) ?>" alt="Photo de profil" class="profile-pic">
    <span><?= htmlspecialchars($recipientInfo['name'] . ' ' . $recipientInfo['lastname']) ?></span>
    <button onclick="closeChat(<?= $recipientInfo['iduser'] ?>)">Fermer</button>
</div>

    </div>

<div class="messages-history" id="messages-<?= $recipientInfo['iduser'] ?>" style="display: flex; flex-direction: column-reverse;">
    <?php foreach (array_reverse($messages) as $message): ?>
        <div class="<?= $message['emetteur'] == $userId ? 'message-envoye' : 'message-recu' ?>" id="message-<?= $message['id'] ?>" oncontextmenu="showDeleteMenu(event, <?= $message['id'] ?>)">
            <p><?= htmlspecialchars($message['message']) ?></p>
            <?php if ($message['media']): ?>
                <?php
                    $mediaPath = base_url('uploads/' . htmlspecialchars($message['media']));
                    $fileExtension = pathinfo($message['media'], PATHINFO_EXTENSION);
                ?>
                <?php if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])): ?>
                    <img src="<?= $mediaPath ?>" alt="Media" style="max-width: 100%; height: auto;">
                <?php elseif (in_array(strtolower($fileExtension), ['mp4', 'webm', 'ogg'])): ?>
                    <video controls style="max-width: 100%; height: auto;">
                        <source src="<?= $mediaPath ?>" type="video/<?= $fileExtension ?>">
                        Votre navigateur ne supporte pas la balise vidéo.
                    </video>
                <?php else: ?>
                    <a href="<?= $mediaPath ?>" download>Télécharger le fichier</a>
                <?php endif; ?>
            <?php endif; ?>

           
        </div>
    <?php endforeach; ?>
</div>


    <form action="#" method="post" onsubmit="sendMessage(event, <?= $recipientInfo['iduser'] ?>)">
        <textarea name="message" id="message-<?= $recipientInfo['iduser'] ?>" placeholder="Écrire un message..."></textarea>
        <input type="file" name="media" id="media-<?= $recipientInfo['iduser'] ?>">
        <input type="submit" value="Envoyer">
    </form>
</div>
<script >
    
function sendMessage(event, friendId) {
    event.preventDefault(); 

    const message = document.getElementById('message-' + friendId).value;
    const media = document.getElementById('media-' + friendId).files[0];
    
    const formData = new FormData();
    formData.append('message', message);
    formData.append('destinataire_id', friendId);
    if (media) {
        formData.append('media', media);
    }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/page-acceuil/sendMessage', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
          
            document.getElementById('message-' + friendId).value = '';
            loadMessages(friendId);
        }
    };
    xhr.send(formData);
}

function loadMessages(friendId) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '/page-acceuil/showMessages/' + friendId, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const messagesContainer = document.getElementById('messages-' + friendId);
            messagesContainer.innerHTML = xhr.responseText;
            messagesContainer.scrollTop = messagesContainer.scrollHeight; 
        }
    };
    xhr.send();
}

document.addEventListener("DOMContentLoaded", function() {
    const friendId = <?= $recipientInfo['iduser'] ?>;
    loadMessages(friendId);
});


function showDeleteMenu(event, messageId) {
    event.preventDefault();
    const allDeleteButtons = document.querySelectorAll('.delete-btn');
    allDeleteButtons.forEach(function(btn) {
        btn.style.display = 'none';
    });

    const deleteBtn = document.querySelector(`#message-${messageId} .delete-btn`);
    if (deleteBtn) deleteBtn.style.display = 'block';
}

function deleteMessage(messageId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce message ?')) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', `http://localhost:8080/page-acceuil/deleteMessage/${messageId}`, true);  // URL complète
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (xhr.status === 200) {
                document.getElementById(`message-${messageId}`).remove();
            } else {
                alert('Erreur lors de la suppression du message.');
            }
        };

        xhr.onerror = function () {
            alert('Erreur de requête.');
        };

        xhr.send();
    }

}


</script>