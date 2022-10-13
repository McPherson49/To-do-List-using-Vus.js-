<?php
session_start();

include("connect.php");
include("./test.php");

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = addslashes($data);
    $data = strip_tags($data);
    return $data;
}
$endpoint = "updatelistlogic.php";
if (getenv('REQUEST_METHOD') == 'POST') {

    $todo_id = (isset($_POST['todo_id'])) ? validate($_POST['todo_id']) : '';
    if (isset($_POST['updateList'])) {
        // checking if the name is passed
        if (!isset($received_data->name)) {
            $errordesc = "All fields must be passed";
            $linktosolve = 'https://';
            $hint = "Kindly pass the required recipient name field in this endpoint";
            $errorData = returnError7003($errordesc, $linktosolve, $hint);
            $data = returnErrorArray($errordesc, $method, $endpoint, $errorData, []);
            respondBadRequest($data);
        } else {
            $name = cleanme($received_data->name);
        }
        // checking if the time is passed
        if (!isset($received_data->time)) {
            $errordesc = "All fields must be passed";
            $linktosolve = 'https://';
            $hint = "Kindly pass the required recipient name field in this endpoint";
            $errorData = returnError7003($errordesc, $linktosolve, $hint);
            $data = returnErrorArray($errordesc, $method, $endpoint, $errorData, []);
            respondBadRequest($data);
        } else {
            $time = cleanme($received_data->time);
        }

        // UPDATING MY DATABASE
        $stmt = $conn->prepare("UPDATE users SET name=?, time =? WHERE id=?");
        $stmt->bind_param("sss", $name, $time, $todo_id);
        $query_run = $stmt->execute();
        if ($query_run) {
            $maindata = [];
            $errordesc = " ";
            $linktosolve = "htps://";
            $hint = [];
            $errordata = [];
            $text = "To-Do list updated Sucessfully";
            $method = getenv('REQUEST_METHOD');
            $status = true;
            $data = returnSuccessArray($text, $method, $endpoint, $errordata, $maindata, $status);
            respondOK($data);
            // $_SESSION["message"] = "To-Do list Created Sucessfully";
            header("location: index.php");
            exit();
        } else{
            echo $stmt->error;
            // $_SESSION["message"] = "To-Do List Not Created ";
            // header("location: index.php");
            $errordesc="not Save";
            $linktosolve="htps://";
            $hint=["Ensure to use the method stated in the documentation."];
            $errordata=returnError7003($errordesc,$linktosolve,$hint);
            $text="To-Do List Not Created 8998";
            $method=getenv('REQUEST_METHOD');
            $data=returnErrorArray($text,$method,$endpoint,$errordata);
            respondMethodNotAlowed($data);
        }
    }else {
        // $_SESSION["message"] = "To-Do List Not Created ";
        // header("location: index.php");
        $errordesc = "Method not allowed";
        $linktosolve = "htps://";
        $hint = ["Ensure to use the method stated in the documentation."];
        $errordata = returnError7003($errordesc, $linktosolve, $hint);
        $text = "To-Do List Not updated";
        $method = getenv('REQUEST_METHOD');
        $data = returnErrorArray($text, $method, $endpoint, $errordata);
        respondMethodNotAlowed($data);
        exit();
    }
}
