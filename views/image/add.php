<div id="upload">
    <video id="webcam" autoplay style="transform: scaleX(-1);"></video>
    <button id="takePhoto">
        Take a photo
    </button>
    <canvas id="photo" style="width: 300px; height: 300px;" ></canvas>
    <form enctype="multipart/form-data" id="uploadForm" method="POST" >
        <input type="file" name="image" id="userfile" />
        <input type="submit" name="submit" value="Upload" />
    </form>
</div>
<script>
    let video = document.getElementById('webcam');
    let canvas = document.getElementById('photo');
    let context = canvas.getContext('2d');

    navigator.getUserMedia({
        audio: false,
        video: {
            width: 300,
            height: 300
        }
    }, (stream) => {
        video.srcObject = stream;
        video.play();
    }, (error) => {
        console.log("Error: " + error.name);
    });

    userfile.onchange = () => {
        let fr = new FileReader();

        fr.onload = () => {
            let img = new Image();
            img.src = fr.result;
            console.log(img);
            // context.clearRect(0, 0, canvas.width, canvas.height);
            context.drawImage(img, 0, 0, 300, 150);
        };

        fr.readAsDataURL(userfile.files[0]);
    };

    takePhoto.onclick = () => {
        context.drawImage(video, 0, 0, 300, 150);
    };
</script>
