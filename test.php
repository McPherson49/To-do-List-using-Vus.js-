<?php

// activate this to prevnt errors from breaking the API , but remove it when debugging
// error_reporting(E_ERROR | E_PARSE);
// LATER UPGRADEs
/*
***Convert ALL API to class
*** Add all link to documentation
*** add more hint

*/

//  ALL RESPONSE CODE
function respondOK($data){
    header('HTTP/1.1 200 OK');
    echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    exit;
}
function respondNotCompleted($data){
    header('HTTP/1.1 202 OK');
    echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        // 202 Accepted Indicates that the request has been received but not completed yet.
    exit;
}
function respondURLChanged($data){
    header('HTTP/1.1 302 URL changed');
    echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
       // The URL of the requested resource has been changed temporarily
    exit;
}
function respondNotFound($data){
    header('HTTP/1.1 404 Not found');
      //  Not found
    echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    exit;
}
function respondForbiddenAuthorized($data){
    header("HTTP/1.1 403 Forbidden");
        // 403 Forbidden
    // Unauthorized request. The client does not have access rights to the content. Unlike 401, the client’s identity is known to the server.
    echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    exit;
}
function respondUnAuthorized($data){
    header("HTTP/1.1 401 Unauthorized");
     // the client’s identity is known to the server.
    echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    exit;
}
function respondInternalError($data){
    header("HTTP/1.1 500 Internal Server Error");
        //  internal server error
    echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    exit;
}
function respondBadRequest($data){
    header("HTTP/1.1 400 Bad request");
        // 400 Bad Request
    echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    exit;
}
function respondMethodNotAlowed($data){
    header("HTTP/1.1 405 Method Not allowed");
        // 405 Method Not Allowed
    echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    exit;
}
// ALL RESPONSE CODE
// ALL RESPONSE ERROR
function returnError7001($errordesc,$linktosolve,$hint){
    $data = ["code"=>7001,"text"=>$errordesc,"link"=>"$linktosolve","hint"=>$hint];
     // bad request
    return $data;
}
function returnError7002($errordesc,$linktosolve,$hint){
    $data = ["code"=>7002,"text"=>$errordesc,"link"=>"$linktosolve","hint"=>$hint];
    // Unauthorized
    return $data;
}
function returnError7003($errordesc,$linktosolve,$hint){
    $data = ["code"=>7003,"text"=>$errordesc,"link"=>"$linktosolve","hint"=>$hint];
    // Method Not allowed
    return $data;
}
// ALL ERROR RESPONSE
// RETURN ERROR
function returnErrorArray($text,$method,$endpoint,$errordata,$maindata=[]){
    $text = empty($text) ? '': $text;
    $data = ["status"=>false,"text" => $text,"data" => $maindata, "time" => date("d-m-y H:i:sA",time()), "method" => $method, "endpoint" => $endpoint,"error"=>$errordata];
    return $data;
}
//  RETURN DATA 
function returnSuccessArray($text,$method,$endpoint,$errordata,$data,$status){
    $data = ["status"=>$status,"text" => $text,"data" => $data, "time" => date("d-m-y H:i:sA",time()), "method" => $method, "endpoint" => $endpoint,"error"=>$errordata];
    return $data;
}
// Generated a unique pub key for all users
// generate Unique prive key for company from admin panel
// set Server name on admin $serverName
function getTokenToSendAPI($userPubkey,$companyprivateKey,$minutetoend,$serverName){
    $issuedAt   = new DateTimeImmutable();
    $expire     = $issuedAt->modify("+$minutetoend minutes")->getTimestamp();  
    $serverName = $serverName;
    $username   = "$userPubkey";
    $data = [
        'iat'  => $issuedAt->getTimestamp(),         // Issued at: time when the token was generated
        'iss'  => $serverName,                       // Issuer
        'nbf'  => $issuedAt->getTimestamp(),         // Not before
        'exp'  => $expire,                           // Expire
        'usertoken' => $username,                     // User name
    ];

    // Encode the array to a JWT string.   
    
    //  get token below
    $auttokn= JWT::encode(
        $data,
        $companyprivateKey,
        'HS512'
    );
    return $auttokn;
}
function cleanme($data) {
    global $connect;
    $input = $data;
    // This removes all the HTML tags from a string. This will sanitize the input string, and block any HTML tag from entering into the database.
    // filter_var($geeks, FILTER_SANITIZE_STRING);
    $input = filter_var($input, FILTER_SANITIZE_STRING);
    $input = trim($input, " \t\n\r");
    // htmlspecialchars() convert the special characters to HTML entities while htmlentities() converts all characters.
    // Convert the predefined characters "<" (less than) and ">" (greater than) to HTML entities:
    $input = htmlspecialchars($input, ENT_QUOTES,'UTF-8');
    // prevent javascript codes, Convert some characters to HTML entities:
    $input = htmlentities($input, ENT_QUOTES, 'UTF-8');
    $input = stripslashes(strip_tags($input));
    // $input = mysqli_real_escape_string($connect, $input);

    return $input;
}
function ValidateAPITokenSentIN($serverName,$companyprivateKey,$method,$endpoint){
        $headerName = 'Authorization';
        $headers = getallheaders();
        $signraturHeader = isset($headers[$headerName]) ? $headers[$headerName] : null;
        if($signraturHeader==null){
            $signraturHeader= isset($_SERVER['Authorization'])?$_SERVER['Authorization']:"";
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
        $signraturHeader = trim($_SERVER["HTTP_AUTHORIZATION"]);
    }
    try{
        if (! preg_match('/Bearer\s(\S+)/',$signraturHeader, $matches)) {
            $errordesc="The format sent in does not match the correct format for the API";
            $linktosolve="htps://";
            $hint=["Check if all header values are sent correctly.","Follow the format stated in the documentation","All letters in upper case must be in upper case","Ensure the correct method is used"];
            $errordata=returnError7001($errordesc,$linktosolve,$hint);
            $text="Bad request";
            $data=returnErrorArray($text,$method,$endpoint,$errordata);
            respondUnAuthorized($data);
            exit;
        }

        $jwt = $matches[1];

        if (! $jwt) {
        // No token was able to be extracted from the authorization header
        $errordesc="The format sent in does not match the correct format for the API";
        $linktosolve="htps://";
        $hint=["Check if all header values are sent correctly.","Follow the format stated in the documentation","All letters in upper case must be in upper case","Ensure the correct method is used"];
        $errordata=returnError7001($errordesc,$linktosolve,$hint);
        $text="Bad request";
        $data=returnErrorArray($text,$method,$endpoint,$errordata);
        respondUnAuthorized($data);
        exit;
        }
        $secretKey  = $companyprivateKey;
        $token = JWT::decode($jwt, $secretKey, ['HS512']);
        $now = new DateTimeImmutable();

        if ($token->iss !== $serverName || $token->nbf > $now->getTimestamp() || $token->exp < $now->getTimestamp() || empty($token->usertoken)) {
            $errordesc="Uauthorized";
            $linktosolve="htps://";
            $hint=["Check if all header values are sent correctly.","Ensure token has not expired","Regenerate token","Ensure the correct method is used","Token is case sensitve"];
            $errordata=returnError7001($errordesc,$linktosolve,$hint);
            $text="Unauthorized";
            $data=returnErrorArray($text,$method,$endpoint,$errordata);
            respondUnAuthorized($data);
            exit;
        }
        
        return $token;
    }
//catch exception
catch(Exception $e) {
    // echo 'Message: '.$e->getMessage();
     // No token was able to be extracted from the authorization header
     $errordesc="The format sent in does not match the correct format for the API";
     $linktosolve="htps://";
     $hint=["Check if all header values are sent correctly.","Ensure token has not expired","Regenerate token","Follow the format stated in the documentation","All letters in upper case must be in upper case","Ensure the correct method is used"];
     $errordata=returnError7001($errordesc,$linktosolve,$hint);
     $text="Bad request";
     $data=returnErrorArray($text,$method,$endpoint,$errordata);
     respondUnAuthorized($data);
     exit;
  }
}
?>