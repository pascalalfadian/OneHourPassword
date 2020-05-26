<?php
require('commons.php');
$datetime = new DateTime();
$this_year = intval($datetime->format('Y'));
$this_month = intval($datetime->format('m'));
$this_day = intval($datetime->format('d'));
$this_hour = intval($datetime->format('H'));
// Get names of month, adjusted from https://stackoverflow.com/a/18467892
$month_names = [];
for ($month = 1; $month <= 12; $month++) {
	$dateObj   = DateTime::createFromFormat('!m', $month);
	$month_names[] = $dateObj->format('F');
}
?><!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>One Hour Password Generator</title>
	<style>
		.generated-password {
			font-size: 3rem;
			border: 3px dashed black;
			background-color: lightgrey;
		}
	</style>
</head>
<body>
	<form action="generate-post.php" method="POST">
		<p>
			<label for="year">Year</label>
			<select id="year" name="year">
				<?php for ($year = $this_year - 1; $year <= $this_year + 1; $year++): ?>
					<option value="<?= $year ?>" <?= $year === $this_year ? 'selected' : ''?>><?= $year ?></option>
				<?php endfor; ?>
			</select>
		</p>
		<p>
			<label for="month">Month</label>
			<select id="month" name="month">
				<?php for ($month = 1; $month <= 12; $month++): ?>
					<option value="<?= $month ?>" <?= $month === $this_month ? 'selected' : ''?>><?= $month . ' - ' . $month_names[$month - 1] ?></option>
				<?php endfor; ?>
			</select>
		</p>
		<p>
			<label for="day">Day</label>
			<select id="day" name="day">
				<?php for ($day = 1; $day <= 31; $day++): ?>
					<option value="<?= $day ?>" <?= $day === $this_day ? 'selected' : ''?>><?= $day ?></option>
				<?php endfor; ?>
			</select>
			<br/><small>Please select a valid day of month as it will not be validated.</small>
		</p>
		<label for="hour">Hour</label>
		<select id="hour" name="hour">
			<?php for ($hour = 0; $hour <= 23; $hour++): ?>
				<option value="<?= $hour ?>" <?= $hour === $this_hour ? 'selected' : ''?>><?= "$hour:00 to $hour:59" ?></option>
			<?php endfor; ?>
		</select>
		<p>
			<label for="key">Key</label>
			<input type="text" name="key" minlength="32" required size="64" value="<?= array_key_exists($key_cookie_name, $_COOKIE) ? htmlspecialchars($_COOKIE[$key_cookie_name]) : '' ?>"/>
			<br/><small>For your convenience, key will be stored locally as a HTTPS-only cookie in your browser for 30 days. <strong>Do not use this tool in a shared device!</strong></small>
		</p>
		<input type="submit" value="Get password"/>
	</form>
</body>
</html>