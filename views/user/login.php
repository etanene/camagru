<div id="login-div" class="block">
    <!-- <form action="/user/login" method="post"> -->
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
    let loginDiv = document.getElementById('login-div');
    let loginForm = document.getElementById('login-form');

    loginForm.onsubmit = (event) => {
        event.preventDefault();

        let formData = new FormData(loginForm);

        fetch('/user/login', {
            method: 'POST',
            body: formData
        })
            .then((res) => {
                return res.json();
            })
            .then((data) => {
                console.log(data);
                let errDiv = document.createElement('div');
                errDiv.innerHTML = data.message;
                loginDiv.appendChild(errDiv);
            })
            .catch((err) => {
                console.log(err);
            });
    };
</script>
