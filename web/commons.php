<?php
date_default_timezone_set('Asia/Jakarta');
function generate_key($datetime, $plaintext) {
	return $datetime->format('dH') . substr(base64_encode(hash('sha256', json_encode($plaintext), TRUE)), 0, 9);
}
$key_cookie_name = 'onehourpassword_key';