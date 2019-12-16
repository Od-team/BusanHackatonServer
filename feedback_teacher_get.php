<?php
include "../../../AwsConnectDb.php";
$user_id = $_POST['user_id'];
$user_job = $_POST['user_job'];
try {
    if ($user_job == "student")
        $select = $link->prepare("SELECT * FROM FeedBack WHERE student = ?");
    else
        $select = $link->prepare("SELECT * FROM FeedBack WHERE teacher = ?");
    $select->bindParam(1, $user_id);
    $select->execute();
    if ($select->rowCount() > 0) {
        $data = array();

        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            array_push($data,
                $row);
        }

        header('Content-Type: application/json; charset=utf8');
        $json = json_encode(array("feedback_list" => $data), JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
        echo $json;
    }
} catch (PDOException $E) {
    echo "query fail";
}


?>