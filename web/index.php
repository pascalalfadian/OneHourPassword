<?php
date_default_timezone_set('Asia/Jakarta');
$datetime = new DateTime();
$plaintext = [
	'datetime' => $datetime->format('Y-m-d H:00:00'),
	'key' => ''
];
$plaintext['key'] = getenv('password_secret_key');
if (!$plaintext['key']) {
	$plaintext['key'] = '';
}
$keyed_sha = generate_key($datetime, $plaintext);
function generate_key($datetime, $plaintext) {
	return $datetime->format('dH') . substr(base64_encode(hash('sha256', json_encode($plaintext), TRUE)), 0, 9);
}
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
	<p>Your password for this hour:</p>
	<p><code class="generated-password"><?= htmlspecialchars($keyed_sha) ?></code></p>
	<p><small>Use it to decrypt your file. This password is only available until <?= $datetime->format('Y-m-d H:59:59') ?>.</small></p>
	<hr/>
	<p>Debugging information:
		<ul>
			<li>datetime: <?= htmlspecialchars($plaintext['datetime']) ?></li>
			<li>key length: <?= strlen($plaintext['key']) ?></li>
		</ul>
	</p>
</body>
</html>