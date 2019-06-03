<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= Config::get('title') ?></title>
	<link rel="stylesheet" href="/public/css/layout.css" />
</head>
<body>
	<div class="header">
		HEADER
		<?php if (Session::get('logged')) { ?>
			<a href="/user/logout">Logout</a>
		<?php } ?>
	</div>
	<div class="main">
		<?= $data['content'] ?>
	</div>
	<div class="footer">
		FOOTER
	</div>
</body>
</html>
