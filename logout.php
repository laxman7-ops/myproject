<?php
session_start();
session_unset();
session_destroy();
echo '<script type="text/javascript">';
echo 'alert("Successfully logged out");';
echo 'window.location.href = "index.html";';
echo '</script>';
exit();
?>
