<div id="resetpw-div" class="block">
    <form id="resetpw-id" method="post">
        <div>
            <input type="password" name="password" class="input" placeholder="NEW PASSWORD" />
        </div>
        <div id="form-buttons">
            <input type="submit" value="Change password" id="login-button" />
        </div>
    </form>
</div>
<script>
    const resetpwDiv = document.getElementById('resetpw-div');
    const resetpwForm = document.getElementById('resetpw-form');

    resetpwForm.onsubmit = (event) => {
        event.preventDefault();

        const formData = new FormData(resetpwForm);

        fetch('/user/resetpw', {
            method: 'POST',
            body: formData
        })
            .then((res) => {
                if (res.redirected) {
                    document.location.href = res.url;
                }
                return res.json();
            })
            .then((data) => {
                // let messageDiv = document.getElementById('message');
                
                // if (!messageDiv) {
                //     messageDiv = document.createElement('div');
                //     messageDiv.id = 'message';
                //     resetpwDiv.appendChild(messageDiv);
                // }
                // messageDiv.innerHTML = data.message;
                alert(data.message);
            })
            .catch((err) => {
                console.log('Err: ' + err);
            });
    };
</script>
