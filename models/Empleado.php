<?php

include_once 'db/EntidadBase.php';
class Empleado extends EntidadBase
{
    public $id;
    public $nombre;
    public $email;
    public $sexo;
    public $area_id;
    public $boletin;
    public $descripcion;

    public function __construct()
    {
        $table = "empleados";
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

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * @param mixed $sexo
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    /**
     * @return mixed
     */
    public function getAreaId()
    {
        return $this->area_id;
    }

    /**
     * @param mixed $area_id
     */
    public function setAreaId($area_id)
    {
        $this->area_id = $area_id;
    }

    /**
     * @return mixed
     */
    public function getBoletin()
    {
        return $this->boletin;
    }

    /**
     * @param mixed $boletin
     */
    public function setBoletin($boletin)
    {
        $this->boletin = $boletin;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    //Guarado/edicion de empleados
    public function agregarEditarEmp($acc){
        if($acc=='i'){
            $start = "INSERT INTO";
            $end = "";
        }else{
            $start = "UPDATE";
            $end = " WHERE id = '".$this->id."'";
        }
        $sql = $start." empleados SET 
                   nombre='".$this->nombre."', 
                   email='".$this->email."', 
                   sexo='".$this->sexo."', 
                   area_id='".$this->area_id."', 
                   boletin='".$this->boletin."', 
                   descripcion='".$this->descripcion."' 
        ".$end;

        $this->query =$sql;
        $con = $this->db();
        $save = $con->query($this->query);
        $last_id = $con->insert_id;
        if (!$save) {
            throw new Exception(mysqli_error($con) . "[ $this->query]");
        }
        return array($save,$last_id);
    }
}