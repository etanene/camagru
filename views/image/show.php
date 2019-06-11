<div class="card">
    <img src="http://localhost:8080/public/img/photo/<?= $data['name'] ?>" alt="image1">
    <div>
        Likes: <?= $data['likes']['countLikes'] ?>
        <form action="/like/submit" method="post">
            <input type="hidden" name="user" value="<?= Session::get('logged') ?>" />
            <input type="hidden" name="image" value="<?= $data['name'] ?>" />
            <input type="submit" value="Like" />
        </form>
    </div>
    <?php if (isset($data['comments'])) { 
        foreach ($data['comments'] as $comment) { ?>
        <div class="comment">
            <div class="comment-user"><?= $comment['user'] ?></div>
            <div class="comment-text"><?= $comment['text'] ?></div>
            <div class="comment-date"><?= $comment['date'] ?></div>
        </div>
    <?php }
    } ?>
    <form action="/comment/add" method="post">
        <div>
            <input type="text" name="comment" class="input" />
            <input type="hidden" name="user" value="<?= Session::get('logged') ?>" />
            <input type="hidden" name="image" value="<?= $data['name'] ?>" />
            <input type="hidden" name="author" value="<?= $data['author'] ?>" />
            <input type="submit" value="Send" />
        </div>
    </form>
</div>
