<?php $session = session(); ?>

<?= view('header') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/acceuil.css') ?>">
<div class="content-wrapper">
    <div class="container">
        <div class="new-post">
            <h2>Créer un poste</h2>
            <form action="/page-acceuil/createPost" method="post" enctype="multipart/form-data">
                <textarea name="content" placeholder="Qu'avez-vous à partager ?"></textarea><br>
                <input type="file" name="attachment"><br>
                <input type="submit" value="Publier">
            </form>
        </div>

        <div class="posts">
            <h2>Publications</h2>
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="post">
                        <div class="user-info">
                            <?php if (!empty($post['pdp'])): ?>
                                <img src="<?= base_url('images/' . htmlspecialchars($post['pdp'])) ?>" alt="Profil" style="width: 50px; height: 50px; border-radius: 50%;">
                            <?php else: ?>
                                <img src="<?= base_url('images/default-profile.png') ?>" alt="Profil" style="width: 50px; height: 50px; border-radius: 50%;">
                            <?php endif; ?>
                            <span><?= htmlspecialchars($post['name']) ?> <?= htmlspecialchars($post['lastname']) ?></span>
                        </div>
                        <div class="post-date">
                            Publié le: <?= htmlspecialchars($post['created_at']) ?>
                        </div>
                        <div class="post-content">
                            <?= htmlspecialchars($post['content']) ?>
                        </div>

                        <?php if (!empty($post['attachment'])): ?>
                            <?php
                            $fileExtension = strtolower(pathinfo($post['attachment'], PATHINFO_EXTENSION));
                            $filePath = base_url('images/' . htmlspecialchars($post['attachment']));

                            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                echo "<img src='{$filePath}' alt='Image' style='max-width: 500px;'>";
                            } elseif (in_array($fileExtension, ['mp4', 'webm', 'ogg', 'mkv'])) {
                                $mimeType = "video/" . ($fileExtension === 'mkv' ? 'mp4' : $fileExtension);
                                echo "<video controls style='max-width: 500px;'>";
                                echo "<source src='{$filePath}' type='{$mimeType}'>";
                                echo "Votre navigateur ne supporte pas la balise vidéo.";
                                echo "</video>";
                            }
                            ?>
                        <?php endif; ?>

                        <div class="comments">
    <h3>Commentaires</h3>

    <div class="comments-list-container">
        <?php
        $commentModel = new \App\Models\CommentModel();
        $comments = $commentModel->getComments($post['post_id']);
        ?>

        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <strong><?= htmlspecialchars($comment['name']) ?> <?= htmlspecialchars($comment['lastname']) ?>:</strong>
                    <?= htmlspecialchars($comment['content']) ?>
                    <div class="comment-date"><?= htmlspecialchars($comment['created_at']) ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun commentaire.</p>
        <?php endif; ?>
    </div>
    </div>
    <form action="/page-acceuil/addComment" method="post" class="comment-form">
        <textarea name="comment" placeholder="Ajouter un commentaire..." required></textarea>
        <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>">
        <input type="submit" value="Commenter">
    </form>


                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune publication trouvée.</p>
            <?php endif; ?>
        </div>
    </div>


<?php $session = session(); ?>
<div class="contacts">
        <h2>Mes Contacts</h2>
        <?php if (!empty($friends)): ?>
            <?php foreach ($friends as $friend): ?>
                <div class="contact" onclick="openChat(<?= $friend['iduser'] ?>)">
                    <img src="<?= base_url('images/' . htmlspecialchars($friend['pdp'])) ?>" alt="Contact">
                    <span><?= htmlspecialchars($friend['name'] . ' ' . $friend['lastname']) ?></span>
                </div>

            <!-- Boîte de dialogue cachée pour chaque contact -->
            <div id="chat-<?= $friend['iduser'] ?>" class="chat-box" style="display:none;">
                
                <div class="chat-messages" id="messages-<?= $friend['iduser'] ?>">
                    
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun contact trouvé.</p>
    <?php endif; ?>
</div>
<script src="<?= base_url('assets/js/acceuil.js') ?>"></script>