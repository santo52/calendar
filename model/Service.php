<?php

require_once 'model/Gateway.php';
require_once 'model/Exceptions.php';


class Service {

    private $hostname = 'localhost';
    private $username = 'root';
    private $password = 'Ogaitnas18';
    private $con = null;
    private $contactsGateway    = NULL;
    
    private function openDb() {
        $this->con = mysqli_connect($this->hostname, $this->username, $this->password);
        if(!$this->con){
            throw new Exception("Conexion a la base de datos fallida!");
        }
        if (!mysqli_select_db($this->con, "agenda")) {
            throw new Exception("No se encontro la base de datos contacts en el servidor de base de datos.");
        }
        return $this->con;
    }
    
    private function closeDb() {
        mysqli_close($this->con);
    }
  
    public function __construct() {
        $this->contactsGateway = new Gateway();
    }
    
    public function getAllContacts($order) {
        try {
            $con = $this->openDb();
            $res = $this->contactsGateway->selectAll($con, $order);
            $this->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }
    
    public function getContact($id) {
        try {
            $con = $this->openDb();
            $res = $this->contactsGateway->selectById($con, $id);
            $this->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }
    
    private function validateContactParams( $name, $phone, $email, $address ) {
        $errors = array();
        if ( !isset($name) || empty($name) ) {
            $errors[] = 'Nombre es requerido';
        }
        if ( empty($errors) ) {
            return;
        }
        throw new Exceptions($errors);
    }
    
    public function createNewContact( $name, $phone, $email, $address ) {
        try {
            $con = $this->openDb();
            $this->validateContactParams($name, $phone, $email, $address);
            $res = $this->contactsGateway->insert($con, $name, $phone, $email, $address);
            $this->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }
    
    private function validateContactParamsU( $id, $name, $phone, $email, $address ) {
        $errors = array();
        if ( !isset($id) || empty($id) ) {
            $errors[] = 'El id es requerido';
        }
        if ( !isset($name) || empty($name) ) {
            $errors[] = 'El nombre es requirido';
        }
        if ( !isset($phone) || empty($phone) ) {
            $errors[] = 'El teléfono es requirido';
        }
        if ( !isset($email) || empty($email) ) {
            $errors[] = 'El email es requirido';
        }
        if ( !isset($address) || empty($address) ) {
            $errors[] = 'La dirección es requirida';
        }
        if ( empty($errors) ) {
            return;
        }
        throw new Exceptions($errors);
    }
    
    public function updateContact( $id, $name, $phone, $email, $address ) {
        try {
            $con = $this->openDb();
            $this->validateContactParamsU($id, $name, $phone, $email, $address);
            $res = $this->contactsGateway->update($con, $id, $name, $phone, $email, $address);
            $this->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }
    
    public function deleteContact( $id ) {
        try {
            $con = $this->openDb();
            $res = $this->contactsGateway->delete($con, $id);
            $this->closeDb();
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }
}
?>
