<?php    
    include_once "../services/UsersService.php";
    include_once "../models/ApiResponse.php";

    header('Content-type: application/json');


    /*if(!isset($_POST["user"]) || !isset($_POST["pass"])){
        
        $response = new ApiResponse(false, 400, "Missing params user or pass");

        echo json_encode($response);

        exit();
    }

    $user = $_POST["user"];
    $password = $_POST["pass"];*/

    $service = new UsersService();
    
    $result = $service->authenticateUser();

    if($result->id == -1){
        $response = new ApiResponse(false);
        echo json_encode($response);        
    }else{
        $response = new ApiResponse($result);
        echo json_encode($result);
    }    

    $service->close();
?>