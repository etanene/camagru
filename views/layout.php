<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= Config::get('title') ?></title>
	<link rel="stylesheet" href="/public/css/layout.css" />
</head>
<body>
	<div class="header">
		<div id="logo">
			<a href="/">Camagru</a>
		</div>
		<div id="search">
			<input type="search" placeholder="Search..." />
			<span id="icon"></span>
			<a id="take-pic" href="/image/add/">Take a picture</a>
		</div>
		<div id="user-nav">
			<?php if (Session::get('logged')) { ?>
				<span id="user-name"><?= Session::get('logged') ?></span>
				<a href="/">
					<div id="profile" class="icon-nav"></div>
				</a>
				<a href="/">
					<div id="settings" class="icon-nav"></div>
				</a>
				<a href="/user/logout">
					<div id="logout" class="icon-nav"></div>
				</a>
			<?php } else { ?>
				<a href="/user/login">
					<div id="login" class="icon-nav"></div>
				</a>
			<?php } ?>
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
