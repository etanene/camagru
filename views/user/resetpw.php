<div id="resetpw-div" class="block">
    <form id="resetpw-id" method="post">
        <div>
            <input type="password" name="password" class="input" placeholder="NEW PASSWORD" />
        </div>
        <div>
            <input type="submit" value="Change password" id="login-button" />
        </div>
    </form>
</div>
<script>
    const resetpwDiv = document.getElementById('resetpw-div');
    const resetpwForm = document.getElementById('resetpw-form');
    import {validatePassword} from 'views/utils/validate.js';

    resetpwForm.password.onchange = (event) => {
        if (!validatePassword(event.target.value)) {
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
                }
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
