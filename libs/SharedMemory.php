<?php

class SharedMemory {

    private $pathFile;
    private $nameToKey = array();
    private $key;
    private $id;
    function __construct($pathFile) {
        $this->pathFile = $pathFile;
        $this->key = ftok($this->pathFile, 'K');

        $this->id = shm_attach($this->key, 100000);

        if(!$this->id)
            die('Unable to create shared memory segment');

        $this->refreshMemoryVarList();

        // Paranoiac mode
        if (!is_array($this->nameToKey)){
            $this->nameToKey = array();
        }

        switch(count($this->nameToKey)){
            case 0 :
                $this->nameToKey[] = '';
            case 1 :
                $this->nameToKey[] = '';
        }
        $this->updateMemoryVarList();
        shm_put_var($this->id, 1, shm_has_var($this->id, 1)?(shm_get_var($this->id, 1) + 1):1);
    }

    function __sleep(){
        shm_detach($this->id);
    }

    function __destruct(){
        try {
            if (shm_get_var($this->id, 1) == 1) {
                // I am the last listener so kill shared memory space
                $this->remove();
            } else {
                shm_put_var($this->id, 1, shm_get_var($this->id, 1) - 1);
                shm_detach($this->id);
            }
        } catch (Exception $ex) {
            $this->remove();
            trigger_error("Can't delete shared memory : ".$ex->getMessage());
        }
    }

    function __wakeup(){
        $this->id = sem_get($this->key);
        shm_attach($this->id);
        $this->refreshMemoryVarList();
        shm_put_var($this->id, 1, shm_get_var($this->id, 1) + 1);
    }

    function getKey(){
        return $this->key;
    }

    function remove(){
        shm_remove($this->id);
    }

    function refreshMemoryVarList(){
        if (!shm_has_var($this->id, 0)){
            $this->updateMemoryVarList();
        }
        $this->nameToKey = shm_get_var($this->id, 0);
    }

    function updateMemoryVarList(){
        shm_put_var($this->id, 0, $this->nameToKey);
    }

    function has($var) {
        if(!in_array($var, $this->nameToKey)){
            $this->refreshMemoryVarList();
        }
        return in_array($var, $this->nameToKey) && shm_has_var($this->id, array_search($var, $this->nameToKey));
    }

    function __get($var){
        if(!in_array($var, $this->nameToKey)){
            $this->refreshMemoryVarList();
        }
        return shm_get_var($this->id, array_search($var, $this->nameToKey));
    }

    function __set($var, $val){
        if(!in_array($var, $this->nameToKey)){
            $this->refreshMemoryVarList();
            $this->nameToKey[] = $var;
            $this->updateMemoryVarList();
        }
        shm_put_var($this->id, array_search($var, $this->nameToKey), $val);
    }
}