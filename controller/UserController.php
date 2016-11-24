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
    
    public function handleRequest() {
        try {
            $handle = isset($_REQUEST['handle'] )?$_REQUEST['handle'] :NULL;

            if($this->getIsAjax()){
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
            } else {

                if (!$handle || $handle == 'list') {
                    $this->listContacts();
                } elseif ($handle == 'delete') {
                    $this->deleteContact();
                } else {
                    $this->showError("Pagina no encontrada", "Pagina para la operacion " . $op . " no fue encontrada!");
                }
            }

        } catch ( Exception $e ) {
            $this->showError("Error en la Application", $e->getMessage());
        }
    }
    
    public function listContacts() {
        $orderby = isset($_GET['orderby'])?$_GET['orderby']:NULL;
        $contacts = $this->contactsService->getAllContacts($orderby);
        include 'view/userList.php';
    }

    public function deleteContact() {
        $id = isset($_GET['id']) ? $_GET['id'] : NULL;
        if ( !$id )
            throw new Exception('Internal error.');
        
        $this->contactsService->deleteContact($id);
        $this->redirect('index.php');
    }
    
    public function showError($title, $message) {
        include 'view/error.php';
    }

    public function redirect($location) {
        header('Location: '.$location);
    }
}
?>
