<?php
$keyword = $_POST['search'];
header('Location: index.php?action=search&id=' . $_SESSION['id'] . '&value='.$keyword);
exit();
?>