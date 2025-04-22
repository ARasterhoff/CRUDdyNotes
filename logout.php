<?php
// One simple job: end the user's session and peace out
session_start();
session_destroy();
header("Location: login.php");
exit();
