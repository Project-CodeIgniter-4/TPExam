
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
    deleteBtn.style.display = 'block';
}

function deleteMessage(messageId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce message ?')) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/messages/deleteMessage/' + messageId, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log('Message supprimé : ' + xhr.responseText);
              
                const messageElement = document.getElementById('message-' + messageId);
                messageElement.remove();
            } else {
                console.log('Erreur de suppression : ' + xhr.status);
                alert('Erreur lors de la suppression du message.');
            }
        };
        
        xhr.onerror = function () {
            console.log('Erreur de requête.');
            alert('Erreur de requête.');
        };
        
        xhr.send();
    }
}
