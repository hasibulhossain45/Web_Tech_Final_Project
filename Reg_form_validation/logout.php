<?php
session_start();
session_unset();
session_destroy();

// after logout -->> validation.html
header("Location: validation.html");
exit();
?>
