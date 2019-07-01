<div id="upload">
    <video id="webcam" style="width: 480px; height: 360px;" autoplay style="transform: scaleX(-1);"></video>
    <button id="takePhoto">
        Take a photo
    </button>
    <canvas id="photo"></canvas>
    <form enctype="multipart/form-data" id="uploadForm" method="POST" >
        <input type="file" name="image" id="userfile" />
        <input type="submit" name="submit" value="Upload" />
    </form>
</div>
<script>
    let video = document.getElementById('webcam');
    let canvas = document.getElementById('photo');
    canvas.width = video.offsetWidth;
    canvas.height = video.offsetHeight;
    let context = canvas.getContext('2d');
    let img = new Image();

    navigator.getUserMedia({
        audio: false,
        video: true
    }, (stream) => {
        video.srcObject = stream;
        video.play();
    }, (error) => {
        console.log("Error: " + error.name);
    });

    userfile.onchange = () => {
        let fr = new FileReader();

        fr.onload = () => {
            img.src = fr.result;
            context.clearRect(0, 0, canvas.width, canvas.height);
            console.log(img);
            context.drawImage(img, 0, 0, 640, 480);
        };

        fr.readAsDataURL(userfile.files[0]);
    };

    takePhoto.onclick = () => {
        context.drawImage(video, 0, 0, 480, 360);
    };

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
