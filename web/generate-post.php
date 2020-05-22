<?php
require('commons.php');
$year = $_POST['year'];
$month = $_POST['month'];
$day = $_POST['day'];
$hour = $_POST['hour'];
$key = $_POST['key'];
$datetime = DateTime::createFromFormat('Y-m-d H:i:s', "$year-$month-$day $hour:00:00");
$plaintext = [
	'datetime' => $datetime->format('Y-m-d H:00:00'),
	'key' => $key
];
if (!$plaintext['key']) {
	$plaintext['key'] = '';
}
$keyed_sha = generate_key($datetime, $plaintext);
setcookie($key_cookie_name, $key, time() + 60 * 60 * 24 * 30, '', '', TRUE, TRUE);
?><!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>One Hour Password - Password for the future</title>
	<style>
		.generated-password {
			font-size: 3rem;
			border: 3px dashed black;
			background-color: lightgrey;
		}
	</style>
</head>
<body>
	<p>Your password for <?= $datetime->format('l, d-M-Y H:i:s') ?> and 59 minutes after:</p>
	<p><code class="generated-password"><?= htmlspecialchars($keyed_sha) ?></code></p>
	<p>
		Use this password to <em>encrypt</em> your file. At the time mentioned above, it will be visible in the <a href="/">index page</a>.
		You can also tell your students/recipients that the valid password will start with <?= substr($keyed_sha, 0, 4) ?>.
	</p>	
	<p><a href="/generate-get.php">Click here to repeat the process.</a></p>
	<hr/>
	<p><small>Debugging information:
		<ul>
			<li>datetime: <?= htmlspecialchars($plaintext['datetime']) ?></li>
			<li>key length: <?= strlen($plaintext['key']) ?></li>
		</ul>
	</small></p>
</body>
</html>