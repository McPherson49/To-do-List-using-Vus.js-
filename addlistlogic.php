<?php 
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL); 
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
$endpoint = "addlistlogic.php";

$received_data = json_decode(file_get_contents("php://input"));

// print_r($received_data);
// exit;
// $data = array();
// if ($data -> action == 'fetchall'){

// }
// INSERTING TO MY DATABASE
if (getenv('REQUEST_METHOD') == 'POST') {
                        // checking if the name is passed
                        if (!isset($received_data->name)){
                            $errordesc = "All fields must be passed";
                            $linktosolve = 'https://';
                            $method=getenv('REQUEST_METHOD');
                            $hint = "Kindly pass the required recipient name field in this endpoint";
                            $errorData = returnError7003($errordesc, $linktosolve, $hint);
                            $data = returnErrorArray($errordesc, $method, $endpoint, $errorData, []);
                            respondBadRequest($data);
                            
                        }else{
                            $name = cleanme($received_data->name);
                        }
                        // checking if the time is passed
                        if (!isset($received_data ->time)){
                            $errordesc = "All fields must be passed";
                            $linktosolve = 'https://';
                            $method=getenv('REQUEST_METHOD');
                            $hint = "Kindly pass the required recipient name field in this endpoint";
                            $errorData = returnError7003($errordesc, $linktosolve, $hint);
                            $data = returnErrorArray($errordesc, $method, $endpoint, $errorData, []);
                            respondBadRequest($data);
                        }else{
                            $time = cleanme($received_data->time);
                        }
                        // check if none of the field is empty
                        if ( empty($name) || empty($time) ){
                        $errordesc = "Insert all fields";
                        $linktosolve = 'https://';
                        $method=getenv('REQUEST_METHOD');
                        $hint = "Kindly pass value to the name, time ";
                        $errorData = returnError7003($errordesc, $linktosolve, $hint);
                        $data = returnErrorArray($errordesc, $method, $endpoint, $errorData, []);
                        respondBadRequest($data);
                        }

                        // INSERTING INTO MY DATABASE
                        $stmt = $conn->prepare("INSERT INTO users (name, time) VALUES (?, ?)");
                        $stmt->bind_param("ss", $name, $time);
                        $query_run = $stmt->execute();
                        if($query_run){
                            $maindata=[
                                'name'=>$name,
                                'time'=>$time
                            ];
                            $errordesc=" ";
                            $linktosolve="htps://";
                            $hint=[];
                            $errordata=[];
                            $text="To-Do list Created Sucessfully";
                            $method=getenv('REQUEST_METHOD');
                            $status=true;
                            $data=returnSuccessArray($text, $method, $endpoint, $errordata, $maindata, $status);
                            respondOK($data);
                        }else{
                            echo $stmt->error;
                            // $_SESSION["message"] = "To-Do List Not Created ";
                            // header("location: index.php");
                            $errordesc="Method not allowed";
                            $linktosolve="htps://";
                            $hint=["Ensure to use the method stated in the documentation."];
                            $errordata=returnError7003($errordesc,$linktosolve,$hint);
                            $text="To-Do List Not Created 8998";
                            $method=getenv('REQUEST_METHOD');
                            $data=returnErrorArray($text,$method,$endpoint,$errordata);
                            respondMethodNotAlowed($data);
                        }
    
}else{
    // $_SESSION["message"] = "To-Do List Not Created ";
    // header("location: index.php");
    $errordesc="Method not allowed";
    $linktosolve="htps://";
    $hint=["Ensure to use the method stated in the documentation."];
    $errordata=returnError7003($errordesc,$linktosolve,$hint);
    $text="method not allowed";
    $method=getenv('REQUEST_METHOD');
    $data=returnErrorArray($text,$method,$endpoint,$errordata);
    respondMethodNotAlowed($data);
}