<?php
include './sso.php';
$qianrong = new Qianrong('XXX', 'XXX', 'http://localhost/ssophp/auth_callback.php');
$arr = explode('&', $_SERVER['QUERY_STRING']);
$code = '';
foreach($arr as $key => $value) {
    $item = explode('=', $value);
    if ($item[0] === 'code') {
        $code = $item[1];
    }
}
$userinfo = $qianrong -> getUserInfo($code);
if ($userinfo -> id) {
    session_start();
    $_SESSION['userInfo'] = json_encode($userinfo);
    header("Location: http://localhost/ssophp/index.php", true, 301);
}
?>