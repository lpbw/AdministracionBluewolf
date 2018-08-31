<?php
include_once "../helpers/DatabaseConfig.php";
include_once "../models/CredentialModel.php";

/**
 * CredentialsService short summary.
 *
 * CredentialsService description.
 *
 * @version 1.0
 * @author isaac.ojeda
 */
class CredentialsService
{
    private $conf;
    private $folderName = "credenciales";

    /**
     * Summary of __construct
     */
    function __construct(){
        $this->conf = new DatabaseConfig();
    }

    /**
     * Summary of saveImage
     * @param mixed $image 
     * @param mixed $name 
     */
    private function saveImage($image,$name){
        
        $path = $_SERVER["DOCUMENT_ROOT"]."/$this->folderName/$name";
        $data = base64_decode($image);
        
        $fp = fopen($path,"wb");
        fwrite($fp, $data);
        fclose($fp);
    }
    /**
     * Summary of saveCredential
     * @param CredentialModel $newCredential 
     * 
     */
    public function saveCredential($newCredential){

        $frontPhoto = "$newCredential->ocrDigits-front.png";
        $backPhoto = "$newCredential->ocrDigits-back.png";

        $query = "INSERT INTO firmas(ocr,id_usuario,foto_1,foto_2,logitud,latitud,fecha_captura,seccion) 
                  VALUES('$newCredential->ocrDigits',$newCredential->idUser,'$frontPhoto','$backPhoto',$newCredential->longitude,$newCredential->latitude,'$newCredential->date_stamp',$newCredential->section)";
        
        $this->conf->execute_sql($query);        

        $this->saveImage($newCredential->frontImg, "$frontPhoto");
        $this->saveImage($newCredential->backImg , "$backPhoto");
    }

    /**
     * Regresa true o false si existe un ocr
     * @param mixed $ocr 
     * @return bool
     */
    public function existsOcr($ocr){

        $query = "SELECT 1 FROM firmas WHERE ocr = $ocr";
        
        $result = $this->conf->execute_sql($query);

        return $result->num_rows > 0;                    
    }
    /**
     * Summary of closeDatabase
     */
    public function closeDatabase(){
        $this->conf->close();
    }
}