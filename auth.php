<?php
include './sso.php';
$qianrong = new Qianrong('XXX', 'XXX', 'http://localhost/ssophp/auth_callback.php');
$qianrong -> redirectAuthUrl('a=12');
?>