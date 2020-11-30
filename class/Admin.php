<?php
  require 'Bd_function.php';


  function CargoDet(){
    $consultar = "SELECT tc.Id_cargo, tc.Nombre, tc.Descripcion, (SELECT COUNT(tp.Id_cargo) FROM tbl_persona tp WHERE tc.Id_cargo = tp.Id_cargo ) 'CantPers' FROM tbl_cargo_persona tc GROUP BY tc.Id_cargo";
    $resultado = Database::getInstance()->getDb()->prepare($consultar);
    $resultado->execute();
    $rows = array();
    while($r = $resultado->fetchAll(PDO::FETCH_ASSOC)) {
      $rows = $r;
    }
    echo json_encode($rows);
  }

  function aggCargo(){
    $nombre = $_POST['name'];
    $descr = $_POST['descr'];
    $array=Administracion::aggCargo($nombre, $descr);
    if ($array) {
        echo json_encode(array( 'status' => '200', 'msg' => $array ));
    } else {
        echo json_encode(array( 'status' => '400', 'msg' =>'Data Update Successfully'));
    }
  }
  
  function ediCargo(){
    $idC = $_POST['id'];
    $nombre = $_POST['name'];
    $descr = $_POST['descr'];
    $array=Administracion::ediCargo($idC,$nombre, $descr);
    if ($array) {
        echo json_encode(array( 'status' => '200', 'msg' => $array ));
    } else {
        echo json_encode(array( 'status' => '400', 'msg' =>'Data Update Successfully'));
    }
  }

  function delCargo(){
    $idC = $_POST['id'];
    $array=Administracion::delCargo($idC);
    if ($array) {
        echo json_encode(array( 'status' => '200', 'msg' => $array ));
    } else {
        echo json_encode(array( 'status' => '400', 'msg' =>'Data Update Successfully'));
    }
  }

  function NotifDet(){
    $consultar = "SELECT * FROM tbl_tipo_notificacion ";
    $resultado = Database::getInstance()->getDb()->prepare($consultar);
    $resultado->execute();
    $rows = array();
    while($r = $resultado->fetchAll(PDO::FETCH_ASSOC)) {
      $rows = $r;
    }
    echo json_encode($rows);
  }

  function aggNotif(){
    $nombre = $_POST['name'];
    $array=Administracion::aggNotif($nombre);
    if ($array) {
        echo json_encode(array( 'status' => '200', 'msg' => $array ));
    } else {
        echo json_encode(array( 'status' => '400', 'msg' =>'Data Update Successfully'));
    }
  }

  function ediNotif(){
    $idN = $_POST['id'];
    $nombre = $_POST['name'];
    $array=Administracion::ediNotif($idN,$nombre);
    if ($array) {
        echo json_encode(array( 'status' => '200', 'msg' => $array ));
    } else {
        echo json_encode(array( 'status' => '400', 'msg' =>'Data Update Successfully'));
    }
  }

  function delNotif(){
    $idN = $_POST['id'];
    $array=Administracion::delNotif($idN);
    if ($array) {
        echo json_encode(array( 'status' => '200', 'msg' => $array ));
    } else {
        echo json_encode(array( 'status' => '400', 'msg' =>'Data Update Successfully'));
    }
  }

  if (isset($_POST['action']) && function_exists($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case "CargoDet":{
            CargoDet();
        }break;
        case "aggCargo":{
            aggCargo();        
        }break;
        case "ediCargo":{
            ediCargo();
        }break;
        case "delCargo":{
            delCargo();
        }break;
        case "NotifDet":{
            NotifDet();
        }break;
        case "aggNotif":{
            aggNotif();
        }break;
        case "ediNotif":{
            ediNotif();
        }break;
        case "delNotif":{
            delNotif();
        }break;
        case "":{
            
        }break;
        default: die('Access denied for this function!');
    }
  } else {
      die('error');
  }