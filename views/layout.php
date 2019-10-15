<!DOCTYPE html>
<html lang="en">
<head>
	<meta
		charset="UTF-8"
		name='viewport' 
    	content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'
	/>
	<title><?= Config::get('title') ?></title>
	<link rel="stylesheet" href="/public/css/layout.css" />
</head>
<body>
	<div class="header">
		<div id="header-bar">
			<div id="logo">
				<a href="/">Camagru</a>
			</div>
			<div id="search">
				<!-- <input type="search" placeholder="Search..." />
				<span id="icon"></span> -->
				<a id="take-pic" href="/image/add/">Take a picture</a>
			</div>
			<div id="user-nav">
				<?php if (Session::get('logged')) { ?>
					<span id="user-name"><?= Session::get('logged') ?></span>
					<a href="/user/profile/<?= Session::get('logged') ?>">
						<div id="profile" class="icon-nav"></div>
					</a>
					<a href="/user/settings">
						<div id="settings" class="icon-nav"></div>
					</a>
					<a href="/user/logout">
						<div id="logout" class="icon-nav"></div>
					</a>
				<?php } else { ?>
					<a href="/user/login">
						<div id="login" class="header-button">Log in</div>
					</a>
					<a href="/user/register">
						<div id="register" class="header-button">Register</div>
					</a>
				<?php } ?>
			</div>
		</div>

	</div>
	<div class="main">
		<?= $data['content'] ?>
	</div>
	<div class="footer">
		afalmer-
	</div>
</body>
</html>
