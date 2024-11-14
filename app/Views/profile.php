
<?= view('header') ?>
<div class="profile-container">
    <img src="<?= base_url('images/' . htmlspecialchars($user['pdp'])) ?>" alt="Photo de profil">
    <div class="profile-info">
        <h2><?= htmlspecialchars($user['name']) . ' ' . htmlspecialchars($user['lastname']) ?></h2>
    </div>
    <div class="profile-action">
        <?php if ($isFriend): ?>
            <span><i class="fas fa-user-friends"></i> Ami(e)s</span>
        <?php elseif ($friendRequestStatus === 'envoyé'): ?>
            <span>Demande envoyée</span>
        <?php elseif ($friendRequestStatus === 'pending'): ?>
            <span>Demande en attente</span>
        <?php else: ?>
            <button onclick="sendFriendRequest(<?= $user['iduser'] ?>)">Inviter</button>
        <?php endif; ?>
    </div>
</div>



<div class="posts-container">
    <h3>Publications de <?= htmlspecialchars($user['name']) ?></h3>
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <div class="post-content"><?= htmlspecialchars($post['content']) ?></div>
                <?php if ($post['attachment']): ?>
                    <?php
                        
                        $attachmentPath = base_url('uploads/' . htmlspecialchars($post['attachment']));
                        $fileExtension = pathinfo($post['attachment'], PATHINFO_EXTENSION);
                    ?>

                    <?php if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])): ?>
                        <img src="<?= $attachmentPath ?>" alt="Image" style="max-width: 500px; height: auto;">

                    <?php elseif (in_array(strtolower($fileExtension), ['mp4', 'webm', 'ogg'])): ?>
                        <video controls style="max-width: 500px; height: auto;">
                            <source src="<?= $attachmentPath ?>" type="video/<?= $fileExtension ?>">
                            Votre navigateur ne supporte pas la balise vidéo.
                        </video>

                    <?php else: ?>
                        <a href="<?= $attachmentPath ?>" download>Télécharger le fichier</a>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="post-date"><?= htmlspecialchars($post['created_at']) ?></div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune publication trouvée.</p>
    <?php endif; ?>




       
       <script>
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
</script>

