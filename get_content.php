<?php
include "../../../AwsConnectDb.php";
$teacher = $_POST['teacher'];
$student = $_POST['student'];

try {
    $select = $link->prepare("SELECT * FROM FeedBack WHERE teacher = ? and student = ?");
    $select->bindParam(1, $teacher);
    $select->bindParam(2, $student);
    $select->execute();

    if ($select->rowCount() > 0)
    {
        $data = array();

        while($row=$select->fetch(PDO::FETCH_ASSOC))
        {
            array_push($data,
                $row);
        }

        header('Content-Type: application/json; charset=utf8');
        $json = json_encode(array("feedback_list"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        echo $json;
    }} catch (PDOException $E) {

    echo "query fail";
}


?>