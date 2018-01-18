<?php

//	DEFINE URL PATH FOR TESTING
switch(SRVHOST)
{
    case "whatsthebuzz":
        $myURLroot = "http://whatsthebuzz";
        $myHTTP = "http://";
        break;
    case "whatsthe.buzz":
        $myURLroot = "https://whatsthe.buzz";
        $myHTTP = "https://";
        break;
}

?>

<center><a href="<?php echo $myURLroot;?>/admin">admin home</a> |
    add logo |
    add coupon |
    <a href="<?php echo $myURLroot;?>/admin/changepassword">change password</a> |
    <a href="<?php echo $myURLroot;?>/admin/myreports">report summary</a> |
    <a href="<?php echo $myURLroot;?>/admin/graphs">graphs</a> |
    <a href="<?php echo $myURLroot;?>/admin/settings">settings</a>
</center>