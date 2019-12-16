<?php
include "../../../AwsConnectDb.php";
$user_id = $_POST['id'];
$pw = $_POST['pw'];
$job = $_POST['job'];

try {
    $select = $link->prepare("SELECT id FROM UserInfo WHERE id = ?");
    $select->bindParam(1, $user_id);
    $select->execute();
    $row = $select->fetch();
} catch (PDOException $E) {
    echo "query fail";
}

// 가입된 아이디가 없다면 가입시킴.
if($row['id'] == null){

    $password_hash = password_hash($pw, PASSWORD_DEFAULT);

    try {
        $statement = $link->prepare("INSERT INTO UserInfo VALUES (null ,?,?,?)");
        $statement->bindParam(1, $user_id);
        $statement->bindParam(2, $password_hash);
        $statement->bindParam(3, $job);
        $statement->execute();
    } catch (Exception $E) {
        echo "insert fail" + $E;
    }
    echo "success";
}
else{
    echo "fail";
}


?>