<?php
date_default_timezone_set('Asia/Jakarta');
$datetime = new DateTime();
$plaintext = [
	'datetime' => $datetime->format('Y-m-d H:00:00'),
	'key' => ''
];
$blank_sha = generate_key($datetime, $plaintext);
$plaintext['key'] = getenv('password_secret_key');
$keyed_sha = generate_key($datetime, $plaintext);
function generate_key($datetime, $plaintext) {
	return $datetime->format('dH') . '-' . substr(base64_encode(hash('sha256', json_encode($plaintext), TRUE)), 0, 9);
}
?><!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>One Hour Password</title>
</head>
<body>
	<h1>Welcome!</h1>
	<h2>tl;dr</h2>
	<p><strong>Here is your password, copy-and-paste it to your encrypted file: <code><?= htmlspecialchars($keyed_sha) ?></code>.</strong></p>
	<h2>Additional details</h2>
	<p>Here is some extra information for debugging details:
		<ul>
			<li>datetime: <code><?= htmlspecialchars($plaintext['datetime']) ?></code></li>
			<li>blank_sha: <code><?= htmlspecialchars($blank_sha) ?></code></li>
		</ul>
	</p>
</body>
</html>