<?php
include "../../../AwsConnectDb.php";
$master_id = $_POST['master_id'];

try {
    $select = $link->prepare("SELECT * FROM Room WHERE master_id = ?");
    $select->bindParam(1, $master_id);
    $select->execute();
    $row = $select->fetch();
} catch (PDOException $E) {
    echo "query fail";
}


if ($row['room_number'] != null){
    try {
        $select = $link->prepare("DELETE FROM Room WHERE master_id = ?");
        $select->bindParam(1, $master_id);
        $select->execute();
        $row = $select->fetch();
    } catch (PDOException $E) {
        echo "query fail";
    }
}
?>