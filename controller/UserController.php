<?php

require_once 'model/Service.php';

class UserController {
    
    private $contactsService = NULL;
    private $isAjax;
    
    public function __construct() {
        $this->contactsService = new Service();
        $this->isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    public function getIsAjax(){
        return $this->isAjax;
    }

    public function redirect($location) {
        header('Location: '.$location);
    }
    
    public function handleRequest() {
        try {
            if (!$this->getIsAjax()){
                $handle = isset($_GET['handle'] )?$_GET['handle'] :NULL;

                if (!$handle || $handle == 'list') {
                    $this->listContacts();
                } elseif ($handle == 'new') {
                    $this->saveContact();
                } elseif ($handle == 'delete') {
                    $this->deleteContact();
                } elseif ($handle == 'show') {
                    $this->showContact();
                } else {
                    $this->showError("Pagina no encontrada", "Pagina para la operacion " . $op . " no fue encontrada!");
                }
            } else{
                $handle = isset($_REQUEST['handle'] )?$_REQUEST['handle'] :NULL;
                if (!$handle || $handle == 'edit') {
                    echo json_encode($this->contactsService->getContact($_REQUEST['id']));
                } elseif($handle == 'createPost'){
                    $this->contactsService->createNewContact($_REQUEST['all']['name'], $_REQUEST['all']['phone'], $_REQUEST['all']['email'], $_REQUEST['all']['address']);
                } elseif($handle == 'editPost'){
                    echo json_encode($this->contactsService->updateContact($_REQUEST['all']['id'], $_REQUEST['all']['name'], $_REQUEST['all']['phone'], $_REQUEST['all']['email'], $_REQUEST['all']['address']));
                } elseif($handle == 'createCalendar'){
                    $calendar = new CalendarController();
                    echo json_encode($calendar->create($_REQUEST['all']['title'], $_REQUEST['all']['description'], $_REQUEST['all']['start'], $_REQUEST['all']['end']));
                }
            }
        } catch ( Exception $e ) {
            // alcunas excepciones desconocidas se capturan aqui, se usa pagina de error para mostrar el mismo.
            $this->showError("Error en la Application", $e->getMessage());
        }
    }
    
    public function listContacts() {
        $orderby = isset($_GET['orderby'])?$_GET['orderby']:NULL;
        $contacts = $this->contactsService->getAllContacts($orderby);
        include 'view/userList.php';
    }
    
    public function saveContact() {
       
        $title = 'Nuevo contacto';
        
        $name = '';
        $phone = '';
        $email = '';
        $address = '';
       
        $errors = array();

        if ( isset($_POST['form-submitted']) ) {
            
            $name       = isset($_POST['name']) ?   $_POST['name']  :NULL;
            $phone      = isset($_POST['phone'])?   $_POST['phone'] :NULL;
            $email      = isset($_POST['email'])?   $_POST['email'] :NULL;
            $address    = isset($_POST['address'])? $_POST['address']:NULL;

            try {
                $this->contactsService->createNewContact($name, $phone, $email, $address);
                $this->redirect('index.php');
                return;
            } catch (Exceptions $e) {
                $errors = $e->getErrors();
            }
        }
                
        include 'view/newUser.php';
    }
 



    public function deleteContact() {
        $id = isset($_GET['id'])?$_GET['id']:NULL;
        if ( !$id ) {
            throw new Exception('Internal error.');
        }
        
        $this->contactsService->deleteContact($id);
        
        $this->redirect('index.php');
    }
    
    public function showContact() {
        $id = isset($_GET['id'])?$_GET['id']:NULL;
        if ( !$id ) {
            throw new Exception('Internal error.');
        }
        
        $title = 'Actualizar un contacto';
        
        if ( isset($_POST['formUpdate-submitted']) ){
        
            $id       = isset($_POST['id']) ?   $_POST['id']  :NULL;
            $name       = isset($_POST['name']) ?   $_POST['name']  :NULL;
            $phone      = isset($_POST['phone'])?   $_POST['phone'] :NULL;
            $email      = isset($_POST['email'])?   $_POST['email'] :NULL;
            $address    = isset($_POST['address'])? $_POST['address']:NULL;
            
            try {
                $this->contactsService->updateContact($id, $name, $phone, $email, $address);
                $this->redirect('index.php');
                return;
            } catch (Exceptions $e) {
                $errors = $e->getErrors();
            }
        }
        

        $contact = $this->contactsService->getContact($id);
        
        include 'view/contact.php';
    }
    
    public function showError($title, $message) {
        include 'view/error.php';
    }
}
?>
