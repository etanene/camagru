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
    let stickers = [];
    // let img = new Image();
    let videoBlock = document.getElementById('video-webcam');

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
        context.drawImage(video, 0, 0, 480, 360);
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

        console.log(target);
        

        move = (event) => {
            console.log(event);
            console.log(event.pageX);
            console.log(event.pageY);
            target.style.left = event.layerX - target.offsetWidth / 2 + 'px';
            target.style.top = event.layerY - target.offsetHeight / 2 + 'px';
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

    // userfile.onchange = () => {
    //     let fr = new FileReader();

    //     fr.onload = () => {
    //         img.src = fr.result;
    //         context.clearRect(0, 0, canvas.width, canvas.height);
    //         console.log(img);
    //         context.drawImage(img, 0, 0, 480, 360);
    //     };

    //     fr.readAsDataURL(userfile.files[0]);
    // };

    

    // uploadForm.onsubmit = (e) => { 
    //     e.preventDefault();
    //     if (!img.src) {
    //         return ;
    //     }

    //     fetch('http://localhost:8080/image/add/', {
    //         method: 'POST',
    //         headers: {'Content-type' : 'multipart/form-data'},
    //         body: new FormData(uploadForm)
    //     })
    //         .then((res) => {
    //             return (res.json());
    //         })
    //         .then((data) => {
    //             alert(data.message);
    //         });
    // };
</script>
