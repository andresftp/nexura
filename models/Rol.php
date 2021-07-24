<?php
include_once 'db/EntidadBase.php';
class Rol extends EntidadBase{
    public $id;
    public $nombre;

    public function __construct()
    {
        $table = "roles";
        parent::__construct($table);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }


}