<?php
session_start();
session_unset();  // remove all session variables
session_destroy(); // destroy session completely

header("Location: main_page.php"); // redirect ke main page
exit();
?>
