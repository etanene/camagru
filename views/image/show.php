<?php foreach ($data['images'] as $image) { ?>
    <div class="images">
        <img src="<?= 'http://localhost:8080/public/img/' . $image['image'] ?>" alt="image1">
    </div>
<?php } ?>