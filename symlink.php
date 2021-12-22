<?php

$targetFolder= $_SERVER['DOCUMENT_ROOT'].'/supplier_franchise_management/storage/app/public';
$linkFolder=$_SERVER['DOCUMENT_ROOT'].'/supplier_franchise_management/public/storage';

symlink($targetFolder , $linkFolder);
echo 'Success';

?>

