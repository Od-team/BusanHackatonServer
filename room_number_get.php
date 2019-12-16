<?php
include "../../../AwsConnectDb.php";
$master_id = $_POST['master_id'];
$user_id = $_POST['user_id'];

try {
    $select = $link->prepare("SELECT * FROM Room WHERE master_id = ?");
    $select->bindParam(1, $master_id);
    $select->execute();
    $row = $select->fetch();
} catch (PDOException $E) {
    echo "query fail";
}

if ($row['master_id'] != null){
    $statement = $link->prepare("UPDATE Room Set student_name = ? where master_id = ?");
    $statement->bindParam(1, $user_id);
    $statement->bindParam(2, $master_id);
    $statement->execute();

    echo $row['room_number'];
}
else{
    echo "no data";
}
?>