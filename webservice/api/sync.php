<?php

include_once "../services/CredentialsService.php";
include_once "../services/UsersService.php";
include_once "../models/ApiResponse.php";
include_once "../models/CredentialModel.php";

header('Content-type: application/json');

if (!function_exists('apache_request_headers')) { 
    function apache_request_headers() { 
        foreach($_SERVER as $key=>$value) { 
            if (substr($key,0,5)=="HTTP_") { 
                $key=str_replace(" ","-",ucwords(strtolower(str_replace("_"," ",substr($key,5))))); 
                $out[$key]=$value; 
            }else{ 
                $out[$key]=$value; 
            } 
        } 
        return $out; 
    } 
} 

// Revisamos las credenciales en el header para poder realizar esta operaci�n
$headers = apache_request_headers();
if(!isset($headers['Authorization'])){
    echo json_encode(new ApiResponse(null, 400, "El encabezado Auth no ha sido proporcionado"));
    exit();
}

// Vemos que las credenciales sean correctas
$credentials = base64_decode(substr($headers["Authorization"],6));
list($user,$pass) = split(':',$credentials);

$userService = new UsersService();
$userModel = $userService->authenticateUser($user,$pass);

if($userModel->user_id == -1){
    echo json_encode(new ApiResponse(null, 400, "Credenciales incorrectas en el encabezado"));
    exit();
}

// Seguimos con la operaci�n...

if(!isset($_POST["section"]) ||!isset($_POST["ocr"]) || !isset($_POST["longitude"]) || !isset($_POST["latitude"]) || !isset($_POST["datetime"]) || !isset($_POST["frontimg"]) || !isset($_POST["backimg"])){
    $response = new ApiResponse(null, 400, "Faltan varios parámetros");
    echo json_encode($response);
    exit();
}

$ocrDigits = $_POST["ocr"];
$longitude = $_POST["longitude"];
$latitude = $_POST["latitude"];
$datetime = $_POST["datetime"];
$frontimg = $_POST["frontimg"];
$backimg = $_POST["backimg"];
$section = $_POST["section"];

$service = new CredentialsService();
$newCredential = new CredentialModel();

// Revisamos si existe el OCR
if($service->existsOcr($ocrDigits)){    
    echo json_encode(new ApiResponse(null,403,"El OCR ya existe"));
    exit();
}

$newCredential->date_stamp = $datetime;
$newCredential->latitude = $latitude;
$newCredential->longitude = $longitude;
$newCredential->ocrDigits = $ocrDigits;
$newCredential->frontImg = $frontimg;
$newCredential->backImg = $backimg;
$newCredential->idUser = $userModel->user_id;
$newCredential->section = $section;

$service->saveCredential($newCredential);

$service->closeDatabase();

$response = new ApiResponse(null, 200, "");

echo json_encode($response);

?>