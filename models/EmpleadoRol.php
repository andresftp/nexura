<?php

include_once 'db/EntidadBase.php';
class EmpleadoRol extends EntidadBase
{
    public $empleado_id;
    public $rol_id;

    public function __construct()
    {
        $table = "empleado_rol";
        parent::__construct($table);
    }

    /**
     * @return mixed
     */
    public function getEmpleadoId()
    {
        return $this->empleado_id;
    }

    /**
     * @param mixed $empleado_id
     */
    public function setEmpleadoId($empleado_id)
    {
        $this->empleado_id = $empleado_id;
    }

    /**
     * @return mixed
     */
    public function getRolId()
    {
        return $this->rol_id;
    }

    /**
     * @param mixed $rol_id
     */
    public function setRolId($rol_id)
    {
        $this->rol_id = $rol_id;
    }

    //Guarado/edicion de rol empleado
    public function agregarRolEmp(){
        $sql = "INSERT INTO empleado_rol SET 
                   empleado_id='".$this->empleado_id."', 
                   rol_id='".$this->rol_id."'
        ";

        $this->query =$sql;
        $con = $this->db();
        $save = $con->query($this->query);
        if (!$save) {
            throw new Exception(mysqli_error($con) . "[ $this->query]");
        }
        return $save;
    }

}