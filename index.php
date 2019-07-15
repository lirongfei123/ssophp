<a href="/ssophp/auth.php">登录</a>
<div>当前已经登录的用户信息</div>
<?php
session_start();
print_r($_SESSION);
?>