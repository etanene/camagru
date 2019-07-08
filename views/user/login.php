<div id="login-form" class="block">
    <?php if (isset($data['message'])) { ?>
        <div><?= $data['message'] ?></div>
    <?php } ?>
    <form action="/user/login" method="post">
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
