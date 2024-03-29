<div>
    <div id="comment-notification" class="block">
        <form id="comment-notification-form" method="post">
            <div>
                <input id="notification" type="checkbox" name="notice" <?= $data['checked'] && $data['checked'] ? 'checked' : '' ?> />
                <label for="notification" style="user-select: none; cursor: pointer;">Comment notification</label>
            </div>
        </form>
    </div>
    <div id="change-password" class="block">
        <span>Change password</span>
        <form id="change-password-form">
            <div>
                <input type="password" name="oldpasswd" class="input" placeholder="OLD PASSWORD " />
            </div>
            <div>
                <input type="password" name="newpasswd" class="input" placeholder="NEW PASSWORD" />
            </div>
            <span class="valid-input">Letters and numbers (A-Z, a-z, 0-9). Length 4-12</span>
            <div>
                <input type="password" name="confirmpasswd" class="input" placeholder="CONFIRM PASSWORD" />
            </div>
            <span class="valid-input">Letters and numbers (A-Z, a-z, 0-9). Length 4-12</span>
            <div>
                <input type="submit" value="Save" class="submit" />
            </div>
        </form>
    </div>
    <div id="change-email" class="block">
        <span>Change email</span>
        <form id="change-email-form">
            <div>
                <input type="text" name="newemail" class="input" placeholder="NEW EMAIL" />
            </div>
            <div>
                <input type="submit" value="Save" class="submit" />
            </div>
        </form>
    </div>
    <div id="change-login" class="block">
        <span>Change login</span>
        <form id="change-login-form">
            <div>
                <input type="text" name="newlogin" class="input" placeholder="NEW LOGIN" />
            </div>
            <span class="valid-input">Only letters (A-Z, a-z). Length 4-12</span>
            <div>
                <input type="submit" value="Save" class="submit" />
            </div>
        </form>
    </div>
</div>
<script type="module">
    const changeNotice = document.getElementById('comment-notification-form');
    const changePwForm = document.getElementById('change-password-form');
    const changeEmailForm = document.getElementById('change-email-form');
    const changeLoginForm = document.getElementById('change-login-form');
    
    import {validateEmail, validateLogin, validatePassword} from '/views/utils/validate.js';

    notification.onchange = (event) => {
        const formData = new FormData();
        formData.append('notice', +event.target.checked);

        fetch('/user/settings/notification', {
            method: 'POST',
            body: formData
        })
            .catch((err) => {
                alert('Error!');
            });
    };

    changePwForm.newpasswd.onchange = (event) => {
        if (!validatePassword(event.target.value)) {
            event.target.style.borderColor = 'red';
        } else {
            event.target.style.borderColor = 'initial';
            if (event.target.value === changePwForm.confirmpasswd.value) {
                changePwForm.confirmpasswd.style.borderColor = 'initial';
            } else {
                changePwForm.confirmpasswd.style.borderColor = 'red';
            }
        }
    };

    changePwForm.confirmpasswd.onchange = (event) => {
        if (event.target.value !== changePwForm.newpasswd.value) {
            event.target.style.borderColor = 'red';
        } else {
            event.target.style.borderColor = 'initial';
        }
    };

    changePwForm.onsubmit = (event) => {
        event.preventDefault();

        const formData = new FormData(changePwForm);
        
        fetch('/user/settings/changepasswd', {
            method: 'POST',
            body: formData
        })
            .then((response) => {
                return response.json();
            })
            .then((res) => {
                alert(res.message);
            })
            .catch((err) => {
                alert('Err: ' + err);
            });
    };

    changeEmailForm.newemail.onchange = (event) => {
        if (!validateEmail(event.target.value)) {
            event.target.style.borderColor = 'red';
        } else {
            event.target.style.borderColor = 'initial';
        }
    };

    changeEmailForm.onsubmit = (event) => {
        event.preventDefault();

        const formData = new FormData(changeEmailForm);

        fetch('/user/settings/changeemail', {
            method: 'POST',
            body: formData
        })
            .then((response) => {
                return response.json();
            })
            .then((res) => {
                alert(res.message);
            })
            .catch((err) => {
                alert('Err: ' + err);
            });
    };

    changeLoginForm.newlogin.onchange = (event) => {
        if (!validateLogin(event.target.value)) {
            event.target.style.borderColor = 'red';
        } else {
            event.target.style.borderColor = 'initial';
        }
    };

    changeLoginForm.onsubmit = (event) => {
        event.preventDefault();

        const formData = new FormData(changeLoginForm);

        fetch('/user/settings/changelogin', {
            method: 'POST',
            body: formData
        })
            .then((response) => {
                return response.json();
            })
            .then((res) => {
                alert(res.message);
            })
            .catch((err) => {
                alert('Err: ' + err);
            });
    };
</script>
