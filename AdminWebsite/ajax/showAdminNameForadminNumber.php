<?php
require_once '../include.php';
$adminNumber=isset($_REQUEST['adminNumber'])?$_REQUEST['adminNumber']:null;
if($adminNumber==null)
    echo '';
else{
    $adminName = getAdminNameForadminNumber($adminNumber);
    echo $adminName;
}

?>