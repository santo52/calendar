<?php

class Gateway {
    
    public function selectAll($con, $order) {
        if ( !isset($order) ) $order = "name";

        $dbOrder =  mysqli_real_escape_string($con, $order);
        $dbres = mysqli_query($con, "SELECT * FROM contacts ORDER BY $dbOrder ASC");
        
        $contacts = array();
        while ( ($obj = mysqli_fetch_object($dbres)) != NULL ) {
            $contacts[] = $obj;
        }
        
        return $contacts;
    }
    
    public function selectById($con, $id) {
        $dbId = mysqli_real_escape_string($con, $id);
        $dbres = mysqli_query($con, "SELECT * FROM contacts WHERE id=$dbId");
        return mysqli_fetch_object($dbres);
    }
    
    public function insert($con, $name, $phone, $email, $address ) {
        
        $dbName = ($name != NULL)?"'".mysqli_real_escape_string($con, $name)."'":'NULL';
        $dbPhone = ($phone != NULL)?"'".mysqli_real_escape_string($con, $phone)."'":'NULL';
        $dbEmail = ($email != NULL)?"'".mysqli_real_escape_string($con, $email)."'":'NULL';
        $dbAddress = ($address != NULL)?"'".mysqli_real_escape_string($con, $address)."'":'NULL';
        
        mysqli_query($con, "INSERT INTO contacts (name, phone, email, address) VALUES ($dbName, $dbPhone, $dbEmail, $dbAddress)");
        return mysqli_insert_id($con);
    }
    
    public function update($con, $id, $name, $phone, $email, $address ) {
        $dbId = mysqli_real_escape_string($con, $id);
        $dbName = ($name != NULL)?"'".mysqli_real_escape_string($con, $name)."'":'NULL';
        $dbPhone = ($phone != NULL)?"'".mysqli_real_escape_string($con, $phone)."'":'NULL';
        $dbEmail = ($email != NULL)?"'".mysqli_real_escape_string($con, $email)."'":'NULL';
        $dbAddress = ($address != NULL)?"'".mysqli_real_escape_string($con, $address)."'":'NULL';
        
        mysqli_query($con, "UPDATE contacts SET name=$dbName , phone=$dbPhone , email=$dbEmail , address=$dbAddress WHERE id=$dbId ");
        return mysqli_insert_id($con);
    }
    
    public function delete($con, $id) {
        $dbId = mysqli_real_escape_string($con, $id);
        mysqli_query($con, "DELETE FROM contacts WHERE id=$dbId");
    }
}

?>
