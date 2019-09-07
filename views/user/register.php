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
        <div id="form-buttons">
            <input type="submit" value="Register" id="login-button" />
        </div>
    </form>
    <a href="/user/login" id="reg-button">Log in</a>
</div>
<script>
    const regDiv = document.getElementById('register-div');
    const regForm = document.getElementById('register-form');

    regForm.login.onchange = () => {
          
    };

    regForm.onsubmit = (event) => {
        event.preventDefault();

        const formData = new FormData(regForm);

        fetch('/user/register', {
            method: 'POST',
            body: formData
        })
            .then((res) => {
                console.log(res);
                return res.json();
            })
            .then((data) => {
                // let messageDiv = document.getElementById('message');
                
                // if (!messageDiv) {
                //     messageDiv = document.createElement('div');
                //     messageDiv.id = 'message';
                //     regDiv.appendChild(messageDiv);
                // }
                // messageDiv.innerHTML = data.message;
                alert(data.message);
            })
            .catch((err) => {
                console.log('Err: ' + err);
            });
    }

    function validatePassword(passwd) {
        
    }
</script>
