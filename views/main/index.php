<div id="show-images">
    <div id="sentinel"></div>
</div>
<script type="module">
    import {getImages, createImagesLines} from '/views/utils/getImages.js'
    let imagesBlock = document.getElementById('show-images');
    let sentinel = document.getElementById('sentinel');
    let lastId = 0;

    const observer = new IntersectionObserver((entries) => {
        if (entries[0].intersectionRatio <= 0) {
            return ;
        }
        getImages(lastId)
            .then((res) => {
                if (!res) {
                    return ;
                }
                lastId = createImagesLines(res, lastId, imagesBlock);
                imagesBlock.appendChild(sentinel);
            })
    });
    observer.observe(sentinel);
</script>
 