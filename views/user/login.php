<div id="login-div" class="block">
    <form id="login-form" method="post">
        <div>
            <input type="text" name="login" class="input" placeholder="LOGIN" />
        </div>
        <div>
            <input type="password" name="password" class="input" placeholder="PASSWORD" />
        </div>
        <div id="form-buttons">
            <input type="submit" value="Log in" id="login-button" />
        </div>
    </form>
    <a href="/user/register" id="reg-button">Register</a>
    <a href="/user/reset">Reset password</a>
</div>
<script>
    const loginDiv = document.getElementById('login-div');
    const loginForm = document.getElementById('login-form');

    loginForm.onsubmit = (event) => {
        event.preventDefault();

        const formData = new FormData(loginForm);

        fetch('/user/login', {
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
                //     loginDiv.appendChild(messageDiv);
                // }
                // messageDiv.innerHTML = data.message;
                alert(data.message);
            })
            .catch((err) => {
                console.log('Err: ' + err);
            });
    };
</script>
