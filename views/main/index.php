<div id="show-images">
</div>
<script>

    let imagesBlock = document.getElementById('show-images');
    let targetObserve;
    let lastId;

    getImages = async (last) => {
        let response = await fetch('/image/get/' + last);
        let images = await response.json();

        if (!images) {
            return ;
        }

        let imagesLine = document.createElement('div');
        imagesLine.className = 'card-line';

        images.forEach((image, ind) => {
            let imageDiv = document.createElement('div');
            let imageA = document.createElement('a');
            let imageImg = new Image();

            imageImg.src = 'http://localhost:8080/public/img/photo/' + image['image'];
            imageA.setAttribute('href', '/image/show/' + image['user'] + '/' + image['image']);
            imageA.appendChild(imageImg);
            imageDiv.className = 'card';
            imageDiv.appendChild(imageA);
            imagesLine.appendChild(imageDiv);

            if ((ind + 1) % 3 == 0 || ind == images.length - 1) {
                imagesBlock.appendChild(imagesLine);
                lastId = image['id'];
                targetObserve = imagesLine;
                imagesLine = document.createElement('div');
                imagesLine.className = 'card-line';
            }
        });
    };

    getImages(0)
        .then(() => {
            let optionsObserve = {
                root: null,
                rootMargin: '0px',
                threshold: 0.5  
            };

            let observer = new IntersectionObserver((entries, observer) => {
                getImages(lastId);
            }, optionsObserve);

            observer.observe(targetObserve);
        });

    

</script>