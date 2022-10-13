<?php 
session_start();

include("connect.php");
include("./test.php");

function validate($data ){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = addslashes($data);
    $data = strip_tags($data);
    return $data;
}
$endpoint = "deletelistlogic.php";
if (getenv('REQUEST_METHOD') == 'POST') {

    $todo_id = (isset($_POST['todo_id']) ) ? validate($_POST['todo_id']) : ''; 
    $stmt = $conn->prepare("DELETE FROM users WHERE id =? ");
    $stmt->bind_param("s", $todo_id);
    $query_run = $stmt->execute();
    if($query_run){
        $maindata=[];
        $errordesc=" ";
        $linktosolve="htps://";
        $hint=[];
        $errordata=[];
        $text="To-Do list Deleted Sucessfully";
        $method=getenv('REQUEST_METHOD');
        $status=true;
        $data=returnSuccessArray($text, $method, $endpoint, $errordata, $maindata, $status);
        respondOK($data);
        // $_SESSION["message"] = "To-Do list Created Sucessfully";
        // header("location: index.php");
        if($data = true){
            header("location: index.php"); 
        }else {
            header("location: index.php");
        }
        exit();
    }else{
        // $_SESSION["message"] = "To-Do List Not Created ";
        // header("location: index.php");
        $errordesc="Method not allowed";
        $linktosolve="htps://";
        $hint=["Ensure to use the method stated in the documentation."];
        $errordata=returnError7003($errordesc,$linktosolve,$hint);
        $text="To-Do List Not deleted";
        $method=getenv('REQUEST_METHOD');
        $data=returnErrorArray($text,$method,$endpoint,$errordata);
        respondMethodNotAlowed($data);
            if($data = true){
                header("location: index.php"); 
            }else {
                header("location: index.php");
            }
        exit();
    }
}
