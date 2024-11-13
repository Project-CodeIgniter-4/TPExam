
<?= view('header') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/poste.css') ?>">
<h2>Mes Publications</h2>



<div class="posts">
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <div class="user-info">
                    <img src="<?= base_url('images/' . htmlspecialchars($post['pdp'])) ?>" alt="Profil" style="width: 50px; height: 50px;">
                    <span><?= htmlspecialchars($post['name']) ?> <?= htmlspecialchars($post['lastname']) ?></span>
                </div>
                <div class="post-date">Publié le: <?= htmlspecialchars($post['created_at']) ?></div>
                <div class="post-content"><?= htmlspecialchars($post['content']) ?></div>

                <?php if (!empty($post['attachment'])): ?>
                    <?php
                        $fileExtension = strtolower(pathinfo($post['attachment'], PATHINFO_EXTENSION));
                        $filePath = base_url('images/' . htmlspecialchars($post['attachment']));
                    ?>
                    <?php if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                        <img src="<?= $filePath ?>" alt="Image" style="max-width: 500px;">
                    <?php elseif (in_array($fileExtension, ['mp4', 'webm', 'ogg', 'mkv'])): ?>
                        <video controls style="max-width: 500px;">
                            <source src="<?= $filePath ?>" type="video/<?= ($fileExtension === 'mkv') ? 'mp4' : $fileExtension ?>">
                            Votre navigateur ne supporte pas la balise vidéo.
                        </video>
                    <?php endif; ?>
                <?php endif; ?>

                <form action="<?= base_url('PosteController/deletePost/' . $post['post_id']) ?>" method="post" class="delete-form">
                    <input type="submit" value="Supprimer" class="delete-btn">
                </form>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune publication trouvée.</p>
    <?php endif; ?>
</div>
<script src="<?= base_url('assets/js/poste.js') ?>"></script>