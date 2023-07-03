<?php

include('connection.php');

$parentId = $_POST['parentId'];
function showCategory($parentId)
{
    $sql = "SELECT * FROM members WHERE ParentId = '" . $parentId . "'";
    // echo $sql; exit;
    $result = mysqli_query($GLOBALS['con'], $sql);

    $output = "<ul>\n";

    while ($data = mysqli_fetch_array($result)) {
        $output .= "<li>\n" . $data['Name'];
        $output .= showCategory(($data['id']));
        $output .= "</li>";
    }

    $output .= "</ul>";
    echo $output;
    // Lets check the changes
    return $output;
}

$html = showCategory($parentId); 
echo $html;
?>