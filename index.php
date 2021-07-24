<?php
include_once 'models/Area.php';
include_once 'models/Rol.php';
include_once 'models/Empleado.php';
include_once 'models/EmpleadoRol.php';

$objArea = new Area();
$objRol = new Rol();
$objEmpl = new Empleado();
$objEmRol = new EmpleadoRol();
if($_GET['acc']=='d'&&$_GET['id']!=''){
    $objEmpl->deleteById($_GET['id']);
    $type= 'ok';
    $msj="Empleado Eliminado con exito!";
}
//Guarado de información
$succes='';
if($_POST['guardar']=='guardar'){
    //Seteo de datos y guarado de informacón del empleado
    $insempl = new Empleado();
    $insempl->setId($_GET['id']);
    $insempl->setNombre($_POST['nombre']);
    $insempl->setEmail($_POST['email']);
    $insempl->setSexo($_POST['sexo']);
    $insempl->setAreaId($_POST['area_id']);
    $insempl->setBoletin(($_POST['boletin']=='on')?1:0);
    $insempl->setDescripcion($_POST['descripcion']);
    try {
        $empl = $insempl->agregarEditarEmp($_GET['acc']);
        $type= 'ok';
        $msj="Empleado registrado/Editado con exito!";
    }catch (Exception $e){
        $type= 'error';
        $msj = $e;
    }
    //Guarado de roles de usuario
    if($type=='ok') {
        $empleado_id = ($_GET['acc'] == 'i') ? $empl[1] : $_GET['id'];
        $objEmRol->deleteBy('empleado_id',$empleado_id);
        foreach ($_POST['rol_id'] as $rol){
            $insrolemp = new EmpleadoRol();
            $insrolemp->setEmpleadoId($empleado_id);
            $insrolemp->setRolId($rol);
            $insrolemp->agregarRolEmp();
        }
    }

}

if($_GET['acc'] == 'e'&& $_GET['id']!=''){
    $dataEmpl = $objEmpl->getById($_GET['id']);
    if(count($dataEmpl)>0){
        $nombre = $dataEmpl[0]['nombre'];
        $email = $dataEmpl[0]['email'];
        $sexo = $dataEmpl[0]['sexo'];
        $area_id = $dataEmpl[0]['area_id'];
        $boletin = $dataEmpl[0]['boletin'];
        $descripcion = $dataEmpl[0]['descripcion'];

        $rol_id = array();
        $dRol = $objEmRol->getBy('empleado_id',$_GET['id']);
        foreach ($dRol AS $irol){
            $rol_id[] = $irol->rol_id;
        }
    }
}


?>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="assets/plugins/datatables/DataTables-1.10.25/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/plugins/datatables/AutoFill-2.3.7/css/autoFill.bootstrap5.css"/>
    <link rel="stylesheet" type="text/css" href="assets/plugins/datatables/KeyTable-2.6.2/css/keyTable.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/plugins/datatables/Responsive-2.2.9/css/responsive.bootstrap5.min.css"/>

    <link href="assets/plugins/fontawesome-free-5.15.3-web/css/fontawesome.css" rel="stylesheet">
    <link href="assets/plugins/fontawesome-free-5.15.3-web/css/brands.css" rel="stylesheet">
    <link href="assets/plugins/fontawesome-free-5.15.3-web/css/solid.css" rel="stylesheet">

    <title>Nexura | Empleados</title>
</head>
<body class="bg-light">
<div class="container">
    <main>
        <div class="py-5 text-center">
        </div>
        <?php
        if($_GET['acc']=='i'||$_GET['acc']=='e'||$_GET['acc']=='d'){
            ?>
            <h5>Crear empleado</h5>
        <?php
        if($type=='ok'){
        ?>
            <div class="alert alert-success" role="alert">
                <?php echo $msj ?>
            </div>
            <script>
                setTimeout(function () {
                    location.href = "index.php"
                }, 2000)

            </script>
        <?php
        }elseif($type=='error'){
        ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $msj ?>
            </div>
            <script>
                setTimeout(function () {
                    location.href = "index.php"
                }, 2000)

            </script>
        <?php
        }
        ?>
            <div class="alert alert-primary" role="alert">
                Los campos con asteriscos (*) son obligatorios
            </div>
        <hr/>
            <div class="card">
                <div class="card-body">
                    <form method="post" class="row g-3 needs-validation" novalidate action="<?php echo $_SERVER['REQUEST_URI']?>">
                        <div class="mb-3 row">
                            <label for="nombre" class="col-sm-3 col-form-label">Nombre completo *</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Completo" value="<?php echo $nombre ?>" required>
                                <div class="invalid-feedback">
                                    Nombres completo es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email" class="col-sm-3 col-form-label">Correo electrónico *</label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com" value="<?php echo $email ?>" required>
                                <div class="invalid-feedback">
                                    Correo electrónico es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email" class="col-sm-3 col-form-label">Sexo *</label>
                            <div class="my-3 col-sm-6">
                                <div class="form-check">
                                    <input id="masculino" name="sexo" type="radio" class="form-check-input" value="0" <?php echo ($sexo==0)?"checked":"" ?> required="">
                                    <label class="form-check-label" for="masculino">Masculino</label>
                                </div>
                                <div class="form-check">
                                    <input id="femenino" name="sexo" type="radio" class="form-check-input" value="1" <?php echo ($sexo==1)?"checked":"" ?> required="">
                                    <label class="form-check-label" for="femenino">Femenino</label>
                                </div>
                                <div class="invalid-feedback">
                                    El sexo es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email" class="col-sm-3 col-form-label">Área *</label>
                            <div class="col-sm-6">
                                <select name="area_id" id="area_id" class="form-control" required>
                                    <option value="">-Seleccione una-</option>
                                    <?php
                                    $datArea = $objArea->getAll();
                                    if(count($datArea)>0){
                                        foreach ($datArea AS $item){
                                            $sel = ($item->id==$area_id)?'selected':'';
                                            echo '<option value="'.$item->id.'" '.$sel.'>'.$item->nombre.'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    El área es obligatoria
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="nombre" class="col-sm-3 col-form-label">Descripción *</label>
                            <div class="col-sm-6">
                                <textarea name="descripcion" id="descripcion" class="form-control" rows="" required><?php echo $descripcion ?></textarea>
                                <div class="invalid-feedback">
                                    La descripción es obligatoria
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email" class="col-sm-3 col-form-label">-</label>
                            <div class="col-sm-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="boletin" id="boletin" <?php echo ($boletin==1)?'checked':'' ?>>
                                    <label class="form-check-label" for="invalidCheck">
                                        Deseo recibir boletín informativo
                                    </label>
                                </div>
                                <in
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email" class="col-sm-3 col-form-label">Roles *</label>
                            <div class="col-sm-6">
                                <?php
                                $roles = $objRol->getAll();
                                if(count($roles)>0){
                                    foreach ($roles AS $rol){
                                        $chk = (in_array($rol->id,$rol_id))?'checked':'';
                                        ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="rol_id[]" id="<?php echo $rol->id ?>" value="<?php echo $rol->id ?>" <?php echo $chk ?>>
                                            <label class="form-check-label" for="invalidCheck">
                                                <?php echo $rol->nombre ?>
                                            </label>
                                        </div>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                } ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="col-lg-6 offset-3">
                                <button class="btn btn-primary" name="guardar" value="guardar" type="submit">Guardar</button>
                                <a class="btn btn-primary" href="index.php" >Cancelar</a>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        <?php

        }else{
        ?>
            <a href="?acc=i" class="btn btn-primary"><i class="fas fa-user-ninja vanished"></i> Registrar Empleado</a>
        <hr/>
            <div class="card">
                <div class="card-body">
                    <table id="listEmpl" class="table table-bordered table-striped" width="100%">
                        <thead>
                        <tr>
                            <th><i class="fas fa-user"></i> Nombre</th>
                            <th><i class="fas fa-at"></i> Email</th>
                            <th><i class="fas fa-venus-mars"></i> Sexo</th>
                            <th><i class="fas fa-briefcase"></i> Área</th>
                            <th><i class="fas fa-envelope"></i> Boletin</th>
                            <th> Modificar</th>
                            <th> Eliminar</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <?php
        }
        ?>
    </main>
</div>
</body>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js" ></script>
<script src="js/jquery-3.5.0.js" ></script>

<!--<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>-->
<script type="text/javascript" src="assets/plugins/datatables/DataTables-1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/DataTables-1.10.25/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/AutoFill-2.3.7/js/dataTables.autoFill.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/AutoFill-2.3.7/js/autoFill.bootstrap5.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/KeyTable-2.6.2/js/dataTables.keyTable.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/Responsive-2.2.9/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/Responsive-2.2.9/js/responsive.bootstrap5.js"></script>

<script src="js/defaultPageScripts.js" ></script>

</html>