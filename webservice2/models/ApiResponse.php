<?php

/**
 * ApiResponse short summary.
 *
 * ApiResponse description.
 *
 * @version 1.0
 * @author isaac.ojeda
 */
class ApiResponse
{
    public $response;
   /* public $httpCode;
    public $errorMessage;*/
    /**
     * Inicializa la respuesta de la API
     * @param mixed $response 
     * @param mixed $code 
     * @param mixed $errorMessage 
     */
    function __construct($response){
        $this->response = $response;
       /* $this->httpCode = $code;
        $this->errorMessage = $errorMessage;*/
    }
}
