<?php
    if (isset($_POST['file'])) {
        echo "The delete function is called.";
        unlink($_POST['file']);
        exit;
    }
?>
