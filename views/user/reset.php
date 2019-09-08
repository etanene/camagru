<div id="reset-div" class="block">
    <form id="reset-form" method="post">
        <!-- <div>
            <input type="text" name="login" class="input" placeholder="LOGIN" />
        </div> -->
        <div>
            <input type="text" name="email" class="input" placeholder="EMAIL" />
        </div>
        <div id="form-buttons">
            <input type="submit" value="Reset password" id="login-button" />
        </div>
    </form>
    <a href="/user/login" id="reg-button">Log in</a>
</div>
<script>
    const resetDiv = document.getElementById('reset-div');
    const resetForm = document.getElementById('reset-form');

    resetForm.onsubmit = (event) => {
        event.preventDefault();

        const formData = new FormData(resetForm);

        fetch('/user/reset', {
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
                //     resetDiv.appendChild(messageDiv);
                // }
                // messageDiv.innerHTML = data.message;
                alert(data.message);
            })
            .catch((err) => {
                console.log('Err: ' + err);
            });
    };
</script>
