<?php
include('../includes/db.php');
if($conn){
    echo "Database connected succesfully ! ";
}else{
    echo "Failed to connect to the database";
}
?>