<?php

class PropertiesView extends Properties{


public function getProperties(?String $query_param){
    
    return $this->fetchProperties($query_param);
}

public function getSelectUser($name){

    return $this->fetchselectedUsers($name);

}


}