<?php
session_start();
if(!session_is_registered(username)){
header("location:index.html");
}
?>

<html>
<body>
Login Successful
</body>
</html>