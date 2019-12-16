<?php
include "../../../AwsConnectDb.php";
$user_id = $_POST['id'];
$pw = $_POST['pw'];

try {
    $select = $link->prepare("SELECT * FROM UserInfo WHERE id = ?");
    $select->bindParam(1, $user_id);
    $select->execute();
    $row = $select->fetch();
} catch (PDOException $E) {
    echo "query fail";
}
if ($row['id'] != null){
    if (password_verify($pw, $row['pw'])) {
        echo "success";
        echo "\n";
        echo $row['job'];
    } else {
        echo "fail";
    }
}

?>