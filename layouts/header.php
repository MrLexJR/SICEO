<nav class="blue">
    <div class="nav-wrapper">
      <a href="index.php" class="brand-logo" style="padding-left: 10px;"> SICEO</a>
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="?menu=personal">Personal</a></li>
        <li><a href="?menu=solicitudes">Permisos</a></li>
        <li><a href="?menu=admin">Administración</a></li>
        <li><a href="?menu=salir"><i class="material-icons right">exit_to_app</i>Salir</a></li>
      </ul>
      <ul class="side-nav" id="mobile-demo">
        <li><a href="index.php"><i class="material-icons">home</i>SICEO</a></li>
        <li><div class="divider"></div></li>
        <li><a href="?menu=personal">Persona<i class="material-icons">assignment_ind</i></a></li>
        <li><a href="?menu=solicitudes">Permisos <i class="material-icons">assignment_turned_in</i></a></li>
        <li><a  href="?menu=admin">Administración<i class="material-icons">assignment</i></a></li>
        <li><a href="?menu=salir">Salir<i class="material-icons">exit_to_app</i></a></li>
      </ul>
    </div>
  </nav>

  <script>
  $( document ).ready(function(){
    $(".button-collapse").sideNav();
  })
  </script>