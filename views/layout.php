<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= Config::get('title') ?></title>
	<link rel="stylesheet" href="/public/css/layout.css" />
</head>
<body>
	<div class="left-part">
		<div class="sidebar">
			SIDE
		</div>
		<div class="footer">
			FOOTER
		</div>
	</div>
	<div class="right-part">
		<div class="header">
			HEADER
		</div>
		<div class="main">
			<?= $data['content'] ?>
		</div>
	</div>
</body>
</html>
