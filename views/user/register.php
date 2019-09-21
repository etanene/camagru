<div id="register-div" class="block">
    <form id="register-form" method="post">
        <div>
            <input type="text" name="login" class="input" placeholder="LOGIN" />
        </div>
        <div>
            <input type="password" name="password" class="input" placeholder="PASSWORD" />
        </div>
        <div>
            <input type="text" name="email" class="input" placeholder="EMAIL" />
        </div>
        <div>
            <input type="submit" value="Register" id="login-button" />
        </div>
    </form>
    <a href="/user/login" id="reg-button">Log in</a>
</div>
<script type="module">
    const regDiv = document.getElementById('register-div');
    const regForm = document.getElementById('register-form');
    import {validateEmail, validateLogin, validatePassword} from '/views/utils/validate.js';

    regForm.login.onchange = (event) => {
        if (!validateLogin(event.target.value)) {
            event.target.style.borderColor = 'red';
        } else {
            event.target.style.borderColor = 'initial';
        }
    };

    regForm.password.onchange = (event) => {
        if (!validatePassword(event.target.value)) {
            event.target.style.borderColor = 'red';
        } else {
            event.target.style.borderColor = 'initial';
        }
    };

    regForm.email.onchange = (event) => {
        if (!validateEmail(event.target.value)) {
            event.target.style.borderColor = 'red';
        } else {
            event.target.style.borderColor = 'initial';
        }
    };

    regForm.onsubmit = (event) => {
        event.preventDefault();

        const formData = new FormData(regForm);

        fetch('/user/register', {
            method: 'POST',
            body: formData
        })
            .then((res) => {
                return res.json();
            })
            .then((data) => {
                alert(data.message);
            })
            .catch((err) => {
                console.log('Err: ' + err);
            });
    };
</script>
