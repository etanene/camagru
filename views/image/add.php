<form id="uploadForm">
    <input type="file" id="userfile" />
    <input type="submit" name="submit" value="Upload" />
</form>
<script>
    uploadForm.onsubmit = async (event) => {
        event.preventDefault();
        let blob = await new Promise((resolve) => userfile.toBlob(resolve));
        let response = await fetch('/image/add', {
            method: 'POST',
            data: blob
        });
    }
</script>