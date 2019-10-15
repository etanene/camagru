<div id="resetpw-div" class="block">
    <form id="resetpw-form" method="post">
        <div>
            <input type="password" name="password" class="input" placeholder="NEW PASSWORD" />
        </div>
        <span class="valid-input">Letters and numbers (A-Z, a-z, 0-9). Length 4-12</span>
        <div>
            <input type="password" name="confirmpassword" class="input" placeholder="CONFIRM PASSWORD" />
        </div>
        <span class="valid-input">Letters and numbers (A-Z, a-z, 0-9). Length 4-12</span>
        <div>
            <input type="submit" value="Change password" id="login-button" class="submit" />
        </div>
    </form>
</div>
<script type="module">
    const resetpwDiv = document.getElementById('resetpw-div');
    const resetpwForm = document.getElementById('resetpw-form');
    import {validatePassword} from '/views/utils/validate.js';

    resetpwForm.password.onchange = (event) => {
        if (!validatePassword(event.target.value)) {
            event.target.style.borderColor = 'red';
        } else {
            event.target.style.borderColor = 'initial';
            if (event.target.value === resetpwForm.confirmpassword.value) {
                resetpwForm.confirmpassword.style.borderColor = 'initial';
            } else {
                resetpwForm.confirmpassword.style.borderColor = 'red';
            }
        }
    };

    resetpwForm.confirmpassword.onchange = (event) => {
        if (event.target.value !== resetpwForm.password.value) {
            event.target.style.borderColor = 'red';
        } else {
            event.target.style.borderColor = 'initial';
        }
    };

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
                } else {
                    return res.json();
                }
            })
            .then((data) => {
                data && alert(data.message);
            })
            .catch((err) => {
                alert('Err: ' + err);
            });
    };
</script>
