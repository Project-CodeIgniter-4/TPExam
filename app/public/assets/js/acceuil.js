
    function openChat(friendId) {
        const allChats = document.querySelectorAll('.chat-box');
        allChats.forEach(chat => chat.style.display = 'none');
        
        const chatBox = document.getElementById('chat-' + friendId);
        chatBox.style.display = 'block';

        loadMessages(friendId);
    }

    function closeChat(friendId) {
        const chatBox = document.getElementById('chat-' + friendId);
        chatBox.style.display = 'none';
    }

    function loadMessages(friendId) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/page-acceuil/showMessages/' + friendId, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                document.getElementById('messages-' + friendId).innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }

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