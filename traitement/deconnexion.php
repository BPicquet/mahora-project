<?php
// Destruction de session
unset($_SESSION['id']);
unset($_SESSION['login']);

//Redirection
header("Location: index.php?action=login");
exit();
?>