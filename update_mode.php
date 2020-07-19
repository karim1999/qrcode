<?php
session_name("qrSession");
session_start();
if($_GET['mode']=='night')
{
    $_SESSION["mode"] = 'night';
}
else
{
    $_SESSION["mode"] = 'day';
}

echo $_SESSION["mode"];
return $_SESSION["mode"];
