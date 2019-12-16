<?php
include "../../../AwsConnectDb.php";
$user_id = $_POST['id'];
$randomNum = $_POST['room_number'];


try {
    $select = $link->prepare("SELECT * FROM Room WHERE master_id = ?");
    $select->bindParam(1, $user_id);
    $select->execute();
    $row = $select->fetch();
} catch (PDOException $E) {
    echo "query fail";
}

if($row['room_number'] != null){

    $statement = $link->prepare("UPDATE Room Set room_number = ? where master_id = ?");
    $statement->bindParam(1, $randomNum);
    $statement->bindParam(2, $user_id);
    $statement->execute();

}
else{
    try {
        $statement = $link->prepare("INSERT INTO Room VALUES (?,?,?)");
        $statement->bindParam(1, $user_id);
        $statement->bindValue(2, $randomNum);
        $statement->bindValue(3, "");
        $statement->execute();
    } catch (Exception $E) {
        echo "insert fail" + $E;
    }

}



?>