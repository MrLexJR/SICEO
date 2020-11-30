<?php
  require 'Bd_function.php';

  function agrega()  {
    if ($_SERVER['REQUEST_METHOD']=='POST') {
      $cedula = $_POST['cedula'];
      $genero = $_POST['genero'];
      $nombre = $_POST['nombre'];
      $ap_mat = $_POST['ap_mat'];
      $ap_pat = $_POST['ap_pat'];
      $correo = $_POST['correo'];
      $telefo = $_POST['telefo'];
      $funcio = $_POST['funcio'];
      $cargos = $_POST['cargos'];
      $direcc = $_POST['direcc'];
      $mes_va = $_POST['mes_va'];
      $array=Persona::AggPersona($cedula, $genero, $nombre, $ap_mat, $ap_pat, $correo, $telefo, $funcio, $cargos, $direcc, $mes_va);
      if ($array) {
        echo json_encode(array( 'status' => '200', 'msg' => $array[2] ));
      } else {
        echo json_encode(array( 'status' => '400', 'msg' =>'Data Inserted Successfully'));
      }
    }
  }


  function updDataPers(){
    if ($_SERVER['REQUEST_METHOD']=='POST') {
      $cedula = $_POST['cedula'];
      $correo = $_POST['correo'];
      $telefo = $_POST['telefo'];
      $funcio = $_POST['funcio'];
      $cargos = $_POST['cargos'];
      $direcc = $_POST['direcc'];
      $array=Persona::updDataPers($cedula, $correo, $telefo, $funcio, $cargos, $direcc);
      if ($array) {
        echo json_encode(array( 'status' => '200', 'msg' => $array[2] ));
      } else {
        echo json_encode(array( 'status' => '400', 'msg' =>'Data Inserted Successfully'));
      }
    }
  }
  
  function updtCargo()  {
    $idCargo = $_POST['id'];
    $cedula = $_POST['cedula'];
    $array=Persona::updtCargo($idCargo, $cedula);
    if ($array) {
        echo json_encode(array( 'status' => '200', 'msg' => $array ));
    } else {
        echo json_encode(array( 'status' => '400', 'msg' =>'Data Update Successfully'));
    }
  }

  function updtEstado()  {
    $idPers = $_POST['id'];
    $estado = $_POST['estado'];
    $array=Persona::updtEstado($idPers, $estado);
    if ($array) {
        echo json_encode(array( 'status' => '200', 'msg' => $array ));
    } else {
        echo json_encode(array( 'status' => '400', 'msg' =>'Data Update Successfully'));
    }
  }

  function updtAdmin()  {
    $idPers = $_POST['id'];
    $rol = $_POST['rol'];
    $array=Persona::updtAdmin($idPers, $rol);
    if ($array) {
        echo json_encode(array( 'status' => '200', 'msg' => $array ));
    } else {
        echo json_encode(array( 'status' => '400', 'msg' =>'Data Update Successfully'));
    }
  }

  function updtPassw(){
    $idPers = $_POST['id'];
    $pass = isset($_POST['passw']) ? $_POST['passw'] : '';
    $password = password_hash($pass, PASSWORD_DEFAULT, ['cost'=>14]);
    $array=Persona::updtPassw($idPers, $password);
    if ($array) {
        echo json_encode(array( 'status' => '200', 'msg' => $array ));
    } else {
        echo json_encode(array( 'status' => '400', 'msg' =>'Data Update Successfully'));
    }
  }

  function getPersona(){
    $consultar = "SELECT * FROM view_usuarios ORDER BY `view_usuarios`.`Nombres` ASC";
    $resultado = Database::getInstance()->getDb()->prepare($consultar);
    $resultado->execute();
    $rows = array();
    while ($r = $resultado->fetchAll(PDO::FETCH_ASSOC)) {
        $rows = $r;
    }
    echo json_encode($rows);
  }

  function getCargos(){
    $consultar = "SELECT Id_cargo,Nombre FROM tbl_cargo_persona;";
    $resultado = Database::getInstance()->getDb()->prepare($consultar);
    $resultado->execute();
    $rows = array();
    while ($r = $resultado->fetchAll(PDO::FETCH_ASSOC)) {
      $rows = $r;
    }
    echo json_encode($rows);
  }

  if (isset($_POST['action']) && function_exists($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
      case "agrega":{
        agrega();
      }break;
      case "updtCargo":{
        updtCargo();
      }break;
      case "updtEstado":{
        updtEstado();
      }break;
      case "updtAdmin":{
        updtAdmin();
      }break;
      case "updtPassw":{
        updtPassw();
      }break;
      case "getPersona":{
        getPersona();
      }break;
      case "getCargos":{
        getCargos();
      }break;
      case "updDataPers":{
        updDataPers();
      }break;
      default: die('Access denied for this function!');
    }
  } else {
      die('error');
  }