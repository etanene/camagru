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
</div>
<script>
    let video = document.getElementById('webcam');
    let canvas = document.getElementById('photo');
    let context = canvas.getContext('2d');
    let stickForm = document.getElementById('get-stick');
    let videoBlock = document.getElementById('video-webcam');
    let stickers = [];
    let uploadStickers = [];
    let blobPhoto;

    canvas.width = video.offsetWidth;
    canvas.height = video.offsetHeight;

    navigator.getUserMedia({
        audio: false,
        video: true
    }, (stream) => {
        video.srcObject = stream;
        video.play();
    }, (error) => {
        console.log("Error: " + error.name);
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
            x = event.clientX;
            y = event.clientY;

            target.style.left = target.offsetLeft - newX + 'px';
            target.style.top = target.offsetTop - newY + 'px';
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

    uploadForm.onsubmit = async (event) => { 
        event.preventDefault();

        if (!blobPhoto) {
            return ;
        }

        let formData = new FormData();
        formData.append('image', blobPhoto);

        // if (Object.keys(uploadStickers).length) {
        //     let stickData = {};
            
        //     for (let key in uploadStickers) {
        //         let res = await fetch('/public/img/sticker/' + key);
        //         let blob = await res.blob();

        //         stickData[key] = {};
        //         stickData[key]['image'] = blob;
        //         stickData[key]['x'] = uploadStickers[key].offsetLeft;
        //         stickData[key]['y'] = uploadStickers[key].offsetTop;
        //     }
        //     formData.append('stickers', JSON.stringify(stickData));
        // }

        // console.log(formData);
        // let test = {};
        // formData.forEach((value, key) => {
        //     test[key] = value;
        // });
        // console.log(test);
        // let testup = JSON.stringify(test);
        // console.log(testup);
        // console.log(JSON.parse(testup));
        let response = await fetch('/image/add', {
                method: 'POST',
                // headers: {
                //     'Content-Type': 'multipart/form-data'
                // },
                body: formData
        });
    };
</script>
