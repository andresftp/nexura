<?php

include_once 'db/EntidadBase.php';
class Area extends EntidadBase
{
    public $id;
    public $nombre;

    public function __construct()
    {
        $table= "areas";
        parent::__construct($table);
    }
}