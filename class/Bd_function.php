<?php
require '../ArchivosPhp/Database.php';
class Login {
  public static function ObtenerUser($usuario) {
    $consultar="SELECT tbl_usuario.Usuario,tbl_usuario.Password 'Contraseña',tbl_usuario_rol.Estado, tbl_rol.Nombre 'Rol'
    FROM tbl_usuario,tbl_usuario_rol, tbl_rol WHERE  tbl_usuario.Id_Usuario=tbl_usuario_rol.Id_Usuario 
                AND tbl_rol.Id_Rol =tbl_usuario_rol.Id_Rol AND tbl_usuario.Usuario=?"; //signo de interrogacion es cualquier parametro que se consulte, filtro a id
                try {
                  $resultado = Database::getInstance()->getDb()->prepare($consultar);
      $resultado->execute(array($usuario)); //obtiene los id de la consulta
      $tabla = $resultado->fetch(PDO::FETCH_ASSOC);
      return $tabla;
    } catch (PDOException $e) {
      return null;
    }
  }
}

class Persona{
  public static function AggPersona($cedula ,$genero ,$nombre ,$ap_mat ,$ap_pat ,$correo ,$telefo ,$funcio ,$cargos ,$direcc, $mes_va){
    $password = password_hash($cedula, PASSWORD_DEFAULT, ['cost'=>14]);
    $usuario = "INSERT INTO tbl_usuario ( Usuario, Password, Id_Cedula, mes_licencia) VALUES ( ?, ?, ?,? )";
    $consultar="INSERT INTO tbl_persona(Cedula,Nombre,ApellidoPaterno,ApellidoMaterno,Direccion,Telefono,Genero,Funcion,Email,Id_cargo) VALUES (?,?,?,?,?,?,?,?,?,?)"; 
    try{
      $resultado = Database::getInstance()->getDb()->prepare($consultar);
      $resultado_usuario = Database::getInstance()->getDb()->prepare($usuario);
      $resultado->execute(array($cedula ,$nombre ,$ap_pat ,$ap_mat, $direcc ,$telefo ,$genero ,$funcio ,$correo ,$cargos)); 
      $resultado_usuario->execute(array($cedula, $password,$cedula, $mes_va));
      return null;
    }catch(PDOException $e){
      return($resultado->errorInfo());
    }
  }

  function updDataPers($cedula, $correo, $telefo, $funcio, $cargos, $direcc){
    $consultar="UPDATE tbl_persona SET Direccion= ?, Telefono= ?, Email= ?, Funcion= ?, Id_cargo = ? WHERE Cedula = ?"; 
    try{
      $resultado = Database::getInstance()->getDb()->prepare($consultar);
      $resultado->execute(array($direcc, $telefo, $correo,$funcio,$cargos ,$cedula )); 
      return null;
    }catch(PDOException $e){
      return($resultado->errorInfo());
    }
  }

  public static function RegistrarPermiso($idp,$det,$idu,$fi,$des,$com,$esta,$idtip,$hac,$lug,$ida){
    $us_perm ="INSERT INTO tbl_detalle_usuario (Id_permiso, Detalle, Id_Usuario) VALUES (?,?,?)"; 
    $consultar="INSERT INTO tbl_permisos (Id_Permisos,FechaInicio,FechaFin,Descripcion,Comentario,Id_Estado,Id_Tipo,Hace_Uso,Lugar,id_seccion) VALUES (?,?,?,?,?,?,?,?,?,?)"; 
    try{
    $resultado = Database::getInstance()->getDb()->prepare($consultar);
    $resultado_usuario = Database::getInstance()->getDb()->prepare($us_perm);
    $resultado->execute(array($idp,$fi,$fi,$des,$com,$esta,$idtip,$hac,$lug,$ida)); //obtiene los id de la consulta
    $resultado_usuario->execute(array($idp, $det,$idu));
    return null;
  }catch(PDOException $e){
    return($resultado->errorInfo());
    }
  }
  public static function updtCargo($idCargo, $cedula){
    $consultar="UPDATE tbl_persona SET Id_cargo = ? WHERE Cedula = ?"; 
    try{
      $resultado = Database::getInstance()->getDb()->prepare($consultar);
      $resultado->execute(array($idCargo ,$cedula )); 
      return null;
    }catch(PDOException $e){
      return($resultado->errorInfo());
    }
  }
  public static function updtEstado($idPers,$estado){
    $consultar="UPDATE tbl_usuario_rol SET Estado = ? WHERE Id_Usuario = ?"; 
    try{
      $resultado = Database::getInstance()->getDb()->prepare($consultar);
      $resultado->execute(array($estado ,$idPers )); 
      return null;
    }catch(PDOException $e){
      return($resultado->errorInfo());
    }
  }
  public static function updtAdmin($idPers,$rol){
    $consultar="UPDATE tbl_usuario_rol SET Id_Rol = ? WHERE Id_Usuario = ?"; 
    try{
      $resultado = Database::getInstance()->getDb()->prepare($consultar);
      $resultado->execute(array($rol ,$idPers )); 
      return null;
    }catch(PDOException $e){
      return($resultado->errorInfo());
    }
  }
  public static function updtPassw($idPers,$password){
    $consultar="UPDATE tbl_usuario SET Password = ? WHERE Id_Usuario = ?"; 
    try{
      $resultado = Database::getInstance()->getDb()->prepare($consultar);
      $resultado->execute(array($password ,$idPers )); 
      return null;
    }catch(PDOException $e){
      return($resultado->errorInfo());
    }
  }
}

class Solicitudes{
  public static function Solicitud($estado ,$id,$idUsuer,$dias,$Comentario ){
    $usuario = "UPDATE tbl_usuario SET dias_licencia = dias_licencia - ? WHERE Id_Usuario = ?";
    $consultar="UPDATE tbl_permisos SET Id_Estado=?, Comentario=? WHERE Id_Permisos=?"; 
    try{
      $resultado = Database::getInstance()->getDb()->prepare($consultar);
      $resultado_usuario = Database::getInstance()->getDb()->prepare($usuario);
      $resultado->execute(array($estado, $Comentario ,$id )); 
      $resultado_usuario->execute(array($dias, $idUsuer));
      return null;
    }catch(PDOException $e){
      return($resultado->errorInfo());
    }
  }
  public static function SolicitudCulmin($dia ,$id ){
    $consultar="UPDATE tbl_permisos SET FechaPresentacion=? WHERE Id_Permisos=?"; 
    try{
      $resultado = Database::getInstance()->getDb()->prepare($consultar);
      $resultado->execute(array($dia,$id )); 
      return null;
    }catch(PDOException $e){
      return($resultado->errorInfo());
    }
  }
  public static function ObtenerTodosLosPermsiso($id){
    $consultar = "select * from (SELECT tbl_persona.Nombre,tbl_persona.ApellidoPaterno,tbl_persona.ApellidoMaterno,tbl_persona.Cedula,tbl_permisos.FechaInicio,tbl_permisos.FechaFin,tbl_permisos.Descripcion,(tbl_tipo_permiso.Nombre) as tipo_permiso,tbl_articulos.Titulo,tbl_articulos.art_numero,tbl_articulos.Descripcion AS Descripcionart,(tbl_cargo_persona.Nombre) as cargo , (tbl_seccion.descripcion) as descripsecc from tbl_persona,tbl_permisos,tbl_detalle_usuario,tbl_seccion,tbl_usuario,tbl_tipo_permiso,tbl_articulos,tbl_cargo_persona where tbl_persona.Cedula=tbl_usuario.Id_Cedula and tbl_usuario.Id_Usuario=tbl_detalle_usuario.Id_Usuario and tbl_detalle_usuario.Id_permiso=tbl_permisos.Id_Permisos and tbl_permisos.Id_Tipo=tbl_tipo_permiso.Id_TipoPermiso and tbl_permisos.id_seccion=tbl_seccion.id_seccion and tbl_seccion.id_articulo=tbl_articulos.Id_Articulo and tbl_persona.Id_cargo=tbl_cargo_persona.Id_cargo and tbl_permisos.Id_Permisos=?) as A inner join (SELECT tbl_persona.Nombre as Nombre_recibe, tbl_persona.ApellidoPaterno as ApellidoP_recibe,tbl_persona.ApellidoMaterno as ApellidoM_recibe from tbl_usuario,tbl_usuario_rol,tbl_rol,tbl_persona WHERE tbl_persona.Cedula=tbl_usuario.Id_Cedula and tbl_usuario.Id_Usuario=tbl_usuario_rol.Id_Usuario and tbl_usuario_rol.Id_Rol=tbl_rol.Id_Rol and tbl_rol.Nombre='admin' and tbl_usuario_rol.Estado='activo') as B";
    try{
      $resultado = Database::getInstance()->getDb()->prepare($consultar);
      $resultado->execute(array($id));
      $resultado->execute();
      $tabla = $resultado->fetch(PDO::FETCH_ASSOC);
      return $tabla;
    }
    catch(PDOException $e){
      return false;
    }
  }
}

class Administracion{
  public static function aggCargo($nombre, $des){
    $consultar="INSERT INTO tbl_cargo_persona(Nombre,Descripcion) VALUES (?,?)"; 
    try{
      $resultado = Database::getInstance()->getDb()->prepare($consultar);
      $resultado->execute(array($nombre ,$des)); 
      return null;
    }catch(PDOException $e){
      return($resultado->errorInfo());
    }
  }
  public static function ediCargo($idC,$nombre, $des){
    $consultar="UPDATE tbl_cargo_persona SET Nombre = ?,Descripcion= ? WHERE Id_cargo = ?"; 
    try{
      $resultado = Database::getInstance()->getDb()->prepare($consultar);
      $resultado->execute(array($nombre ,$des,$idC)); 
      return null;
    }catch(PDOException $e){
      return($resultado->errorInfo());
    }
  }
  public static function delCargo($idC){
    $consultar="DELETE FROM tbl_cargo_persona WHERE Id_cargo = ?"; 
    try{
      $resultado = Database::getInstance()->getDb()->prepare($consultar);
      $resultado->execute(array($idC)); 
      return null;
    }catch(PDOException $e){
      return($resultado->errorInfo());
    }
  }

  public static function aggNotif($nombre){
    $consultar="INSERT INTO tbl_tipo_notificacion(Nombre) VALUES (?)"; 
    try{
      $resultado = Database::getInstance()->getDb()->prepare($consultar);
      $resultado->execute(array($nombre)); 
      return null;
    }catch(PDOException $e){
      return($resultado->errorInfo());
    }
  }
  public static function ediNotif($idN,$nombre){
    $consultar="UPDATE tbl_tipo_notificacion SET Nombre = ? WHERE Id_TipoNotific = ?"; 
    try{
      $resultado = Database::getInstance()->getDb()->prepare($consultar);
      $resultado->execute(array($nombre,$idN)); 
      return null;
    }catch(PDOException $e){
      return($resultado->errorInfo());
    }
  }
  public static function delNotif($idN){
    $consultar="DELETE FROM tbl_tipo_notificacion WHERE Id_TipoNotific = ?"; 
    try{
      $resultado = Database::getInstance()->getDb()->prepare($consultar);
      $resultado->execute(array($idN)); 
      return null;
    }catch(PDOException $e){
      return($resultado->errorInfo());
    }
  }

}