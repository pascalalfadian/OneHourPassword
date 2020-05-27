<?php
require('commons.php');
$datetime = new DateTime();
$plaintext = [
	'datetime' => $datetime->format('Y-m-d H:00:00'),
	'key' => getenv('password_secret_key')
];
if (!$plaintext['key']) {
	$plaintext['key'] = '';
}
$keyed_sha = generate_key($datetime, $plaintext);
?><!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>One Hour Password</title>
	<style>
		.generated-password {
			font-size: 3rem;
			border: 3px dashed black;
			background-color: lightgrey;
		}
	</style>
</head>
<body>
	<p>Your password for <?= $datetime->format('l, d-M-Y H:i:s') ?>:</p>
	<p><code class="generated-password"><?= htmlspecialchars($keyed_sha) ?></code></p>
	<p>Use this password to <em>decrypt</em> your file. Keep it safe for this session since it will not be retrievable after the next hour.</p>
	<hr/>
	<p><small>Debugging information:
		<ul>
			<li>datetime: <?= htmlspecialchars($plaintext['datetime']) ?></li>
			<li>key length: <?= strlen($plaintext['key']) ?></li>
		</ul>
	</small></p>
	<p><small>See this project on GitHub: <a href="https://github.com/pascalalfadian/OneHourPassword">https://github.com/pascalalfadian/OneHourPassword</a></small></p>
</body>
</html>