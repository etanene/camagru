<!-- <?php if (isset($data['images'])) {
    foreach ($data['images'] as $image) { ?> -->
    <!-- <div class="card">
        <a href="/image/show/<?= $image['user'] ?>/<?= $image['image'] ?>">
            <img src="http://localhost:8080/public/img/photo/<?= $image['image'] ?>" alt="image1">
        </a>
    </div> -->
<!-- <?php }
} ?> -->

<div id="show-images">
</div>
<script>

    getImages = async () => {
        let response = await fetch('/image/')
    };

    getImages();

</script>