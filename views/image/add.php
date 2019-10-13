<div id="upload">
    <div id="select-stick">
        <form id="get-stick">
            <?php if (isset($data['stickers'])) { 
            foreach ($data['stickers'] as $sticker) { ?>
            <label>
                <input type="checkbox" name="<?= $sticker['image'] ?>" form="get-stick" />
                <img src="http://localhost:8080/public/img/sticker/<?= $sticker['image'] ?>" alt="<?= $sticker['name'] ?>">
            </label>
            <?php }
            } ?>
        </form>
    </div>
    <div id="get-photo">
        <div id="get-pic">
            <div id="video-webcam">
                <video id="webcam" style="width: 480px; height: 360px;" autoplay style="transform: scaleX(-1);"></video>
            </div>
            <button id="takePhoto">
                Take a photo
            </button>
        </div>
        <div id="preview-pic">
            <canvas id="photo"></canvas>
            <form enctype="multipart/form-data" id="uploadForm" method="POST" >
                <input type="file" name="image" id="userfile" />
                <input type="submit" name="submit" value="Upload" />
            </form>
        </div>
    </div>
    <div id="prev-pic-div">
    </div>
</div>
<script>
    const video = document.getElementById('webcam');
    const canvas = document.getElementById('photo');
    const context = canvas.getContext('2d');
    const stickForm = document.getElementById('get-stick');
    const videoBlock = document.getElementById('video-webcam');
    const prevBlock = document.getElementById('prev-pic-div');
    const user = '<?= Session::get('logged') ?>';
    let stickers = [];
    let uploadStickers = [];
    let blobPhoto;

    canvas.width = video.offsetWidth;
    canvas.height = video.offsetHeight;

    fetch('/image/getUserImages/' + user, {
        method: 'GET'
    })
        .then((res) => {
            return res.json();
        })
        .then((data) => {
            if (!data.length) {
                return ;
            }

            const delButtons = document.getElementsByClassName('del-img-btn');
            data.forEach((image, ind) => {
                prevBlock.appendChild(createPrevImage(image.user, image.image));
            });
        })
        .catch((err) => {
            alert('Error');
        });

    navigator.getUserMedia({
        audio: false,
        video: true
    }, (stream) => {
        video.srcObject = stream;
        video.play();
    }, (error) => {
        alert("Error: " + error.name);
    });

    takePhoto.onclick = () => {
        context.clearRect(0, 0, 480, 360);
        context.drawImage(video, 0, 0, 480, 360);

        canvas.toBlob((blob) => {
            blobPhoto = blob;
        });

        for (let key in stickers) {
            context.drawImage(stickers[key], stickers[key].offsetLeft, stickers[key].offsetTop);
            uploadStickers[key] = stickers[key];
        }
    };

    stickForm.onchange = (event) => {
        if (event.target.checked) {
            let stick = new Image();
            
            stick.src = "http://localhost:8080/public/img/sticker/" + event.target.name;
            stick.classList.add('sticker');
            videoBlock.appendChild(stick);
            stickers[event.target.name] = stick;
        } else {
            videoBlock.removeChild(stickers[event.target.name]);
            delete stickers[event.target.name];
        }
    };

    videoBlock.onmousedown = (event) => {
        let target = event.target;
        let x = event.clientX;
        let y = event.clientY;

        move = (event) => {
            let newX = x - event.clientX;
            let newY = y - event.clientY;        
            let left = target.offsetLeft - newX;
            let top = target.offsetTop - newY;

            if (left < 0) {
                target.style.left = 0 + 'px';
            } else if (left > 352) {
                target.style.left = 352 + 'px';
            } else {
                target.style.left = left + 'px';
            }

            if (top < 0) {
                target.style.top = 0 + 'px';
            } else if (top > 232) {
                target.style.top = 232 + 'px';
            } else {
                target.style.top = top + 'px';
            }

            x = event.clientX;
            y = event.clientY;
        };

        videoBlock.onmousemove = (event) => {
            move(event);
        };

        target.onmouseup = () => {
            videoBlock.onmousemove = null;
            target.onmouseup = null;
        };

        target.ondragstart = () => {
            return (false);
        };
    };

    userfile.onchange = () => {
        let fr = new FileReader();

        fr.onload = () => {
            let img = new Image();

            img.onload = () => {
                context.clearRect(0, 0, 480, 360);
                context.drawImage(img, 0, 0, 480, 360);
                canvas.toBlob((blob) => {
                    blobPhoto = blob;
                });
            };
            img.src = fr.result;
        };

        fr.readAsDataURL(userfile.files[0]);
    };

    uploadForm.onsubmit = (event) => { 
        event.preventDefault();

        if (!blobPhoto) {
            return ;
        }

        let formData = new FormData(uploadForm);
        formData.set('image', blobPhoto);

        if (Object.keys(uploadStickers).length) {
            let stickData = {};
            
            for (let key in uploadStickers) {
                stickData[key] = {};
                stickData[key]['x'] = uploadStickers[key].offsetLeft;
                stickData[key]['y'] = uploadStickers[key].offsetTop;
            }
            formData.append('stickers', JSON.stringify(stickData));
        }

        fetch('/image/add', {
                method: 'POST',
                // headers: {
                //     'Content-Type': 'multipart/form-data'
                // },
                body: formData
        })
            .then((res) => {
                return res.json();
            })
            .then((data) => {
                prevBlock.prepend(createPrevImage(data.user, data.imageName));
            })
            .catch((err) => {
                alert('Error');
            });
    };

    function createPrevImage(user, imageName) {
        let imageDiv = document.createElement('div');
        let imageA = document.createElement('a');
        let delButton = document.createElement('button');
        let image = new Image();

        delButton.classList.add('del-img-btn');
        image.src = 'http://localhost:8080/public/img/photo/' + imageName;
        imageA.setAttribute('href', '/image/show/' + user + '/' + imageName);
        imageA.appendChild(image);
        imageDiv.className = 'prev-pic';
        imageDiv.appendChild(imageA);
        imageDiv.appendChild(delButton);
        delButton.addEventListener('click', (event) => {
                    fetch('/image/del/' + imageName, {
                        method: 'DELETE'
                    })
                        .then((res) => {
                            return res.json();
                        })
                        .then((data) => {
                            if (data.message) {
                                alert(data.message);
                            } else {
                                event.target.parentElement.remove();
                            }
                        })
                        .catch((err) => {
                            alert('Error');
                        });
                });

        return (imageDiv);
    };
</script>
