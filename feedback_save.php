<?php
include "../../../AwsConnectDb.php";
$teacher = $_POST['teacher'];
$student = $_POST['student'];
$content = $_POST['content'];

try {
    $statement = $link->prepare("INSERT INTO FeedBack VALUES (?,?,?)");
    $statement->bindParam(1, $teacher);
    $statement->bindParam(2, $student);
    $statement->bindParam(3, $content);
    $statement->execute();
} catch (Exception $E) {
    echo "insert fail" + $E;
}


?>