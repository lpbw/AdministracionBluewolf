<?php    
    include_once "../services/UsersService.php";
    include_once "../models/ApiResponse.php";

    header('Content-type: application/json');

    $service = new UsersService();
    $latitud = $_GET['lat'];
    $longitud = $_GET['lon'];
    $result = $service->authenticateUser($latitud,$longitud);

    if($result->id_usuario == -1){
        $response = new ApiResponse(false);
        echo json_encode($response);        
    }else{
        $response = new ApiResponse($result);
        echo json_encode($result);
    }    

    $service->close();
?>