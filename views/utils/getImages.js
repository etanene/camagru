export async function getImages(last, user = '') {
    let response = await fetch('/image/get/' + last + '/' + user);
    let images = await response.json();

    return (images);
}

export function createImagesLines(images, lastId, imagesBlock, user = '') {
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
            imagesLine = document.createElement('div');
            imagesLine.className = 'card-line';
        }
    });

    return lastId;
}