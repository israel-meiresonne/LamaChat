<?php $this->title = "Mon Blog - " . $this->clean($post['title']); ?>

<article>
    <header>
        <h1 class="postTitle"><?= $this->clean($post['title']) ?></h1>
        <time><?= $this->clean($post['date']) ?></time>
    </header>
    <p><?= $this->clean($post['content']) ?></p>
</article>
<hr />
<header>
    <h1 id="answerTitle">Réponses à <?= $this->clean($post['title']) ?></h1>
</header>
<?php foreach ($comments as $comment): ?>
    <p><?= $this->clean($comment['author']) ?> dit :</p>
    <p><?= $this->clean($comment['content']) ?></p>
<?php endforeach; ?>
<hr />
<form method="post" action="post/comment">
    <input id="autor" name="author" type="text" placeholder="Votre pseudo"
           required /><br />
    <textarea id="txtComment" name="content" rows="4"
              placeholder="Votre commentaire" required></textarea><br />
    <input type="hidden" name="id" value="<?= $post['id'] ?>" />
    <input type="submit" value="Commenter" />
</form>
