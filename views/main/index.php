<?php foreach ($data['images'] as $image) { ?>
    <div class="images">
        <a href="/image/show/<?= $image['user'] ?>/<?= $image['image'] ?>">
            <img src="http://localhost:8080/public/img/<?= $image['image'] ?>" alt="image1">
        </a>
    </div>
<?php } ?>
