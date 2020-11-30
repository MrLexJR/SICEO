<head>
  <script type="text/javascript" src="resources/js/solicitud.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/css/dataTables.material.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/dataTables.material.min.js"></script>
  <link rel="stylesheet" href="http://cdn.shopify.com/s/files/1/1775/8583/t/1/assets/admin-materialize.min.css">
  <link rel="styleshett" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css"></link>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
  <link rel="styleshett" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css"></link>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.js"></script>
</head>

<div class="row">
  <div class="card-panel s12 m12">
    <blockquote>
      <h2> Solicitudes</h2>
    </blockquote>
    <ul class="tabs">
      <li class="tab "><a data-toggle="tab" href="#pendientes">Pendientes</a></li>
      <li class="tab "><a data-toggle="tab" href="#aceptadas">Aceptados</a></li>
      <li class="tab "><a data-toggle="tab" href="#denegadas">Denegados</a></li>
      <li class="tab "><a data-toggle="tab" href="#culminado">Culminados</a></li>
      <li class="tab "><a data-toggle="tab" href="#notificac">Notificado</a></li>
    </ul>
  </div>

  <div id="pendientes" class="col s12 m12 ">
    <div class="card-panel material-table">
      <div class="table-header">
        <span class="table-title">Solicitudes de Permiso</span>
        <div class="actions">
            <a href="#!" class="search-toggle waves-effect btn-flat nopadding"><i
                    class="material-icons">search</i></a>
        </div>
      </div>
      <table id="tbl_solicitudes" class="mdl-data-table" style="width:100%">
        <thead>
          <tr>
            <th>Cédula</th>
            <th>Nombres</th>
            <th>Tipo</th>
            <th>Descripcion</th>
            <th>Recebida</th>
            <th>Inicio/Fin</th>
            <th></th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

  <div id="aceptadas" class="col s12 m12">
    <div class="card-panel material-table">
      <div class="table-header">
        <span class="table-title">Permiso Aceptados</span>
        <div class="actions">
            <a href="#!" class="search-toggle waves-effect btn-flat nopadding"><i
                    class="material-icons">search</i></a>
        </div>
      </div>
      <table id="tbl_solicitudes_acep" class="mdl-data-table" style="width:100%">
        <thead>
          <tr>
            <th>Cédula</th>
            <th>Nombres</th>
            <th>Tipo</th>
            <th>Descripcion</th>
            <th>Inicio/Fin</th>
            <th>Estado</th>
            <th></th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

  <div id="denegadas" class="col s12 m12">
    <div class="card-panel material-table">
      <div class="table-header">
        <span class="table-title">Permiso no Aceptados</span>
        <div class="actions">
            <a href="#!" class="search-toggle waves-effect btn-flat nopadding"><i
                    class="material-icons">search</i></a>
        </div>
      </div>
      <table id="tbl_solicitudes_denegadas" class="mdl-data-table" style="width:100%">
        <thead>
          <tr>
            <th>Cédula</th>
            <th>Nombres</th>
            <th>Tipo</th>
            <th>Descripcion</th>
            <th>Inicio/Fin</th>
            <th></th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

  <div id="culminado" class="col s12 m12">
    <div class="card-panel material-table">
      <div class="table-header">
        <span class="table-title">Permiso no Aceptados</span>
        <div class="actions">
            <a href="#!" class="search-toggle waves-effect btn-flat nopadding"><i
                    class="material-icons">search</i></a>
        </div>
      </div>
      <table id="tbl_solicitudes_culminado" class="mdl-data-table" style="width:100%">
        <thead>
          <tr>
            <th>Cédula</th>
            <th>Nombres</th>
            <th>Tipo</th>
            <th>Descripcion</th>
            <th>Inicio/Fin</th>
            <th>Fecha de Presentación</th>
            <th></th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

  <div id="notificac" class="col s12 m12">
    <div class="card-panel material-table">
      <div class="table-header">
        <span class="table-title">Notificaciones</span>
        <div class="actions">
            <a href="#!" class="search-toggle waves-effect btn-flat nopadding"><i
                    class="material-icons">search</i></a>
        </div>
      </div>
      <table id="tbl_notifaciones" class="mdl-data-table" style="width:100%">
        <thead>
          <tr>
            <th>Cédula</th>
            <th>Nombres</th>
            <th>Descripcion</th>
            <th>Fecha Notificado</th>
            <th>Lugar</th>
            <th>Comentario</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

  <div id="modal2" class="modal modal-fixed-footer">
    <div class="modal-content">
      <nav class="blue">
        <div class="nav-wrapper">
          <a href="#!" class="brand-logo center">Informacion</a>
        </div>
      </nav>
      <div class="row">
        <div class="col s12 m12 ">
          <div id="informacion" class="card-panel row">
            <span class="text-darken-2 col s2 m1">Cedula:</span>
            <span id="pEscCed" class="blue-text text-darken-2 col s2 m2"></span>
            <span class="text-darken-2 col s1 m1">Nombres:</span>
            <span id="pEscNom" class="blue-text center-align text-darken-2 col s5 m5"></span>
            <span class="text-darken-2 col s1 m1">Tipo:</span>
            <span id="pEscTipo" class="blue-text center-align text-darken-2 col s2 m2"></span>
            <span class="text-darken-2 col s6 m2">Descripcion:</span>
            <span id="pEscDesc" class="blue-text center-align text-darken-2 col s6 m4"></span>
            <span class="text-darken-2 col s6 m2">Lugar:</span>
            <span id="pEscLuga" class="blue-text center-align text-darken-2 col s6 m4"></span>
          </div>
        </div>
        <div class="col s12 m12">
          <div class="card-panel">
            <div class=" center-align" id="index-banner">
              <div class="container">
                <div id="clockdiv">
                  <span class="black-text text-darken-4 header">Tiempo faltante</span><br />
                  <div> <span class="days"></span>
                    <div class="smalltext">Dias</div>
                  </div>
                  <div> <span class="hours"></span>
                    <div class="smalltext">Horas</div>
                  </div>
                  <div> <span class="minutes"></span>
                    <div class="smalltext">Minu</div>
                  </div>
                  <div> <span class="seconds"></span>
                    <div class="smalltext">Segu</div>
                  </div>
                </div>
              </div>
              <span id="infoAdic" class="text-darken-2 blue-text"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <a href="#!" id="cierrahilo" class="modal-action modal-close waves-effect waves-green btn-flat">Listo</a>
    </div>
  </div>

  <div id="modal3" class="modal modal-fixed-footer">
    <div class="modal-content">
      <nav class="blue">
        <div class="nav-wrapper">
          <a href="#!" class="brand-logo center">Informacion</a>
        </div>
      </nav>
      <div class="row">
        <div class="col s12 m12 ">
          <div id="informacion1" class="card-panel row">
            <span class="text-darken-2 col s1 m1">Cedula:</span>
            <span id="pEscCed1" class="blue-text text-darken-2 col s2 m2"></span>
            <span class="text-darken-2 col s1 m1">Nombres:</span>
            <span id="pEscNom1" class="blue-text center-align text-darken-2 col s5 m5"></span>
            <span class="text-darken-2 col s1 m1">Tipo:</span>
            <span id="pEscTipo1" class="blue-text center-align text-darken-2 col s2 m2"></span>
              <span class="text-darken-2 col s6 m2">Descripcion:</span>
            <span id="pEscDesc1" class="blue-text center-align text-darken-2 col s6 m4"></span>
            <span class="text-darken-2 col s6 m2">Lugar:</span>
            <span id="pEscLuga1" class="blue-text center-align text-darken-2 col s6 m4"></span>
          </div>
        </div>
        <div class="col s12 m12">
          <div class="card-panel">
            <div class=" center-align" id="index-banner">
              <div class="container">
                <span style="font-size:30px; font-weight: 100; font-family: sans-serif;"
                class="black-text text-darken-4 header">Razón</span><br />
                <p id="pcomentario" class="flow-text">.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Listo</a>
    </div>
  </div>

  <div id="modal4" class="modal modal-fixed-footer">
    <div id="example1"></div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Listo</a>
    </div>
  </div>

  <div id="modal5" class="modal ">
    <div class="container">
      <div class="section center-align">
        <span style="font-size:30px; font-weight: 100; font-family: sans-serif;"
                  class="black-text text-darken-4 header">Escriba la razon</span><br />
        <div class="row">
          <form id="modalComentario">
            <div class="input-field col s12">
              <textarea required="" id="textarea1" class="materialize-textarea" data-length="120"></textarea>
              <label for="textarea1">Comentario</label>
            </div>      
            <div class="input-field offset-s4 col s6" >
              <a class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>     
              <button class="btn waves-effect waves-light" type="submit" name="action">Enviar
                <i class="material-icons right">send</i>
              </button>
            </div>
          </form>
        </div>
    </div>
  </div>
</div>