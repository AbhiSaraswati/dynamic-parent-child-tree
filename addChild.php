<?php
    include('connection.php');

    $cateName = $_POST['childName'];
    $parentCat = $_POST['parentName'];
    $sql = "insert into members (ParentId,Name) values('" . $parentCat . "','" . $cateName . "')";
    // echo ($sql);
    $result = mysqli_query($con, $sql);

    if($result) {
        echo '1';
    } else {
        echo '0';
    }
?>