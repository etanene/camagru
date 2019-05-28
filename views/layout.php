<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= Config::get('title') ?></title>
</head>
<body>
	<div class="header">
		<h3>HEADER</h3>
	</div>
	<div class="main">
		<?= $data['content'] ?>
	</div>
	<div class="footer">
		<h3>FOOTER</h3>
	</div>
</body>
</html>
