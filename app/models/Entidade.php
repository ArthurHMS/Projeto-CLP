<?php

abstract class Entidade {
    protected $id;

    public function __construct() {
        $this->id = round(microtime(true) * 1000);
    }

    public function getId() {
        return $this->id;
    }

    public function __toString() {
        return sprintf("Id: %d\t", $this->id);
    }
}

?>