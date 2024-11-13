
       
       function sendFriendRequest(destinataireId) {
           let button = event.target;
           button.disabled = true;
           button.innerText = 'Demande envoyée';
       
           fetch("<?= base_url('profiles/sendFriendRequest') ?>/" + destinataireId, {
               method: 'POST',
               headers: {
                   'Content-Type': 'application/json',
               }
           })
           .then(response => response.json())
           .then(data => {
               if (!data.success) {
                   alert(data.message);
                   button.disabled = false;
                   button.innerText = 'Inviter';
               }
           })
           .catch(error => {
               alert('Une erreur est survenue.');
               button.disabled = false;
               button.innerText = 'Inviter';
           });
       }
       
       