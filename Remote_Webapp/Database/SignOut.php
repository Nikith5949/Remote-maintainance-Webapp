<?php
session_start();
session_unset();
session_destroy();
session_start();
echo '<script type="text/javascript">alert("sign out succesfull");location="../view/Main.php";</script>';
