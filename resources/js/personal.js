
$(document).ready(function () {
  window.onload = tablaPersona();
  window.onload = cargoPolicia();
  window.onload = infoSolicitud();
  window.onload = TipoNotif();

  $('.search-toggle').click(function () {
    if ($('.hiddensearch').css('display') == 'none')
      $('.hiddensearch').slideDown();
    else
      $('.hiddensearch').slideUp();
  });
  $('.tabs').click(function () {
    $.fn.dataTable.tables({ visible: true, api: true })
      .columns.adjust()
      .responsive.recalc();
  });

  $("#cedula").keydown(function (event) {
    if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode !== 190 && event.keyCode !== 110 && event.keyCode !== 8 && event.keyCode !== 9) {
      return false;
    }
  });
  $("#telefo").keydown(function (event) {
    if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode !== 190 && event.keyCode !== 110 && event.keyCode !== 8 && event.keyCode !== 9) {
      return false;
    }
  });

  $("#upd_telef").keydown(function (event) {
    if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode !== 190 && event.keyCode !== 110 && event.keyCode !== 8 && event.keyCode !== 9) {
      return false;
    }
  });  

  $.ajax({
    type: "POST",
    url: "class/Persona.php",
    data: { action: 'getCargos' },
    success: function (data) {
      cargos = JSON.parse(data);
      var json = JSON.parse(data);
      var sel = document.getElementById('cargo')
      for (var i = 0; i < json.length; i++) {
        var opt = document.createElement('option');
        opt.innerHTML = json[i].Nombre;
        opt.value = json[i].Id_cargo;
        sel.appendChild(opt);
      }
      $('select').material_select();
    }
  });

  $("#savePersona").on("submit", function (e) {
    e.preventDefault();
    var table = $('#datatable').DataTable();
    var cedula = $('#cedula').val().trim();
    var genero = $('#genero').val() || '';
    var nombre = $('#nombres').val().trim();
    var ap_mat = $('#ap_materno').val().trim();
    var ap_pat = $('#ap_paterno').val().trim();
    var correo = $('#email').val().trim();
    var telefo = $('#telefo').val().trim() || '';
    var cargos = $('#cargo').val() || '';
    var mesVac = $('#mes').val() || '';
    var direcc = $('#direccion').val().trim();
    var funcio = $('#funcion').val().trim();
    if (validar()) {
      $.ajax({
        url: 'class/Persona.php',
        method: 'POST',
        data: {
          action: 'agrega',
          cedula: cedula, genero: genero, nombre: nombre, ap_mat: ap_mat, ap_pat: ap_pat, funcio: funcio,
          correo: correo, telefo: telefo, cargos: cargos, direcc: direcc, mes_va: mesVac
        },
        success: function (data) {
          var data = JSON.parse(data);
          if (data.status == "400") {
            Materialize.toast('Persona agregado exitosamente', 4000, 'green accent-4');
            document.getElementById("savePersona").reset();
            tablaPersona();
            table.ajax.reload();
          } else if (data.status == "200") {
            Materialize.toast('Error: ' + data.msg, 4000, 'red lighten-2');
          }
        },
        error: function (data) {
          Materialize.toast(data, 2000);
        },
      });
    }
  });

  $("#upd_Persona").on("submit", function (e) {
    e.preventDefault();
    var table = $('#datatable').DataTable();
    var cedula = p.Cedula;
    var correo = $('#upd_email').val().trim();
    var telefo = $('#upd_telef').val().trim() || '';
    var cargos = $('#cargo1').val() || '';
    var direcc = $('#upd_addre').val().trim();
    var funcio = $('#upd_funci').val().trim();
    var r = confirm("Esta seguro de actualizar los datos?");
    if (r == true) {
      $.ajax({
        url: 'class/Persona.php',
        method: 'POST',
        data: {
          action: 'updDataPers',
          cedula,funcio,correo,telefo,cargos,direcc
        },
        success: function (data) {
          var data = JSON.parse(data);
          if (data.status == "400") {
            Materialize.toast('Datos actualizados exitosamente', 4000, 'green accent-4');
            tablaPersona();
            table.ajax.reload();
            $('#modal1').modal('close');
          } else if (data.status == "200") {
            Materialize.toast('Error: ' + data.msg, 4000, 'red lighten-2');
          }
        },
        error: function (data) {
          Materialize.toast(data, 2000);
        },
      });
    }
  });

  var table = $('#datatable').dataTable({
    dom: "<'hiddensearch'f'>" + "tr" + "<'table-footer'Blip'>",
    renderer: 'material',
    responsive: true,
    sWrapper: "dataTables_wrapper",
    sFilterInput: "form-control input-sm",
    sLengthSelect: "form-control input-sm",
    "ajax": {
      url: 'class/Persona.php',
      method: 'POST',
      data: { action: 'getPersona' },
      "dataSrc": function (json) {
        for (var i = 0, ien = json.length; i < ien; i++) {
          const alert = (json[i]['Estado'] === 'activo') ? '<span class="lighten-5 green green-text text-accent-4 ">activo</span>' : '<span class=" lighten-5 pink pink-text text-accent-2 ">inactivo</span>';
          json[i] = [i + 1, json[i]['Cedula'], json[i]['Nombres'], json[i]['Apellidos'], json[i]['Cargo'], json[i]['Genero'],
            alert,
          "<a title='Opciones' onclick='rolPersona(" + json[i]['Id_Usuario'] + ");' href='#!'><i class='material-icons'>settings_applications</i></a>"
          + "<a title='Informacion' onclick='infoPersona(" + json[i]['Id_Usuario'] + ");' href='#!'><i class='material-icons green-text'>info</i></a>"
            // + "<a title='Reiniciar Contraseña' onclick='updPersona(" + json[i]['Id_Usuario'] + ");' href='#!'><i class='material-icons  blue-grey-text'>lock</i></a>"
            // + "<a title='Enviar Notificacion' onclick='sendNotifi(" + json[i]['Id_Usuario'] + ");' href='#!'><i class='material-icons  teal-text'>notifications_active</i></a>"
          ]
        }
        return json;
      }
    },
    buttons: [
      { text: '<span style="color:#4d4d4d;">Recargar<span>', action: function (e, dt, node, config) { dt.ajax.reload(); tablaPersona(); cargoPolicia(); infoSolicitud(); TipoNotif(); } }
    ],
    "language": {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "_START_ - _END_ de _TOTAL_ ",
      "sInfoEmpty": "No hay registros ",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix": "",
      "sSearch": "",
      "searchPlaceholder": "Busqueda",
      "sUrl": "",
      "sInfoThousands": ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst": '<i class="material-icons">first_page</i>',
        "sLast": '<i class="material-icons">last_page</i>',
        "sNext": '<i class="material-icons">navigate_next</i>',
        "sPrevious": '<i class="material-icons">navigate_before</i>',
      },
      "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      },
      "sLengthMenu": '<span>Ver: </span><select class="browser-default">' +
        '<option value="10">10</option>' + '<option value="20">20</option>' + '<option value="30">30</option>' +
        '<option value="40">40</option>' + '<option value="50">50</option>' + '<option value="-1">Todo</option>' +
        '</select></div>'
    },
    rowReorder: {
      selector: 'td:nth-child(3)'
    },
    "responsive": true,
    "bAutoWidth": false,
    "bDeferRender": true,
    "pagingType": "full",
    "scrollY": "360px",
    "scrollCollapse": true,

  });

  $('ul.tabs').tabs();
  $('select').material_select();
  $("select[required]").css({ position: 'absolute', display: 'inline', height: 0, padding: 0, width: 0 });
  document.getElementById('userPassR').addEventListener("click", function () { updPersona(p.Id_Usuario); });
  document.getElementById('userNotif').addEventListener("click", function () { sendNotifi(p.Id_Usuario); });
});
var next_load = [];
var cargos = [];
var dataSol = [];
var p2 = [];
var p = [];

function habilitar(){
  $('#btn_hab').hide();
  $('#btnupdPersona').show();
  $("#upd_addre").prop('disabled', false);
  $("#upd_telef").prop('disabled', false);
  $("#upd_email").prop('disabled', false);
  $("#upd_funci").prop('disabled', false);
  $("#cargo1").prop('disabled', false);
  $('select').material_select();
}

function cargoPolicia() {
  $.ajax({
    type: "POST",
    url: "class/Persona.php",
    data: { action: 'getCargos' },
    success: function (data) {
      cargos = JSON.parse(data);
      var json = JSON.parse(data);
      var sel = document.getElementById('cargo1')
      for (var i = 0; i < json.length; i++) {
        var opt = document.createElement('option');
        opt.innerHTML = json[i].Nombre;
        opt.value = json[i].Id_cargo;
        sel.appendChild(opt);
      }
      $('select').material_select();
    }
  });
}

function TipoNotif() {
  $.ajax({
    type: "POST",
    url: "class/Admin.php",
    data: { action: 'NotifDet' },
    success: function (data) {
      var json = JSON.parse(data);
      var sel = document.getElementById('tipo')
      for (var i = 0; i < json.length; i++) {
        var opt = document.createElement('option');
        opt.innerHTML = json[i].Nombre;
        opt.value = json[i].Nombre;
        sel.appendChild(opt);
      }
      $('select').material_select();
    }
  });
}

function tablaPersona() {
  $.ajax({
    url: 'class/Persona.php',
    method: 'POST',
    data: { action: 'getPersona' },
    success: function (data) {
      next_load = JSON.parse(data);
    }
  });
}

function setSelectedIndex(s, i) {
  s.options[i - 1].selected = true;
  return;
}

function updPersona(data) {

  p = next_load.find(x => x.Id_Usuario == data);
  if (p.Estado === 'activo') {
    var r = confirm("Reiniciar la contraseña del usuario " + p.Nombres + " " + p.Apellidos + " ?");
    if (r == true) {
      var table = $('#datatable').DataTable();
      $.ajax({
        url: 'class/Persona.php',
        method: 'POST',
        data: { id: p.Id_Usuario, passw: p.Cedula, action: 'updtPassw' },
        success: function (data) {
          var data = JSON.parse(data);
          if (data.status == "400") {
            tablaPersona();
            table.ajax.reload();
            Materialize.toast('Contraseña actualizada', 4000, 'green accent-4');
          } else if (data.status == "200") {
            Materialize.toast('Error: ' + data.msg, 4000, 'red lighten-2');
          }
        },
        error: function (data) {
          Materialize.toast(data, 2000);
        },
      });
    } else {
      return
    }
  } else {
    Materialize.toast('Usuario no activo', 4000, 'red lighten-2');
    return
  }
}

function infoPersona(data) {
  p = next_load.find(x => x.Id_Usuario == data);
  var html = '';
  var tele = (p.Telefono) ? p.Telefono : '....';
  var estadoSpan = document.getElementById("infoEstado");
  const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
  estadoSpan.className = "";
  estadoSpan.innerHTML = " " + p.Estado + "&nbsp;";
  document.getElementById('infoNom').innerHTML = " " + p.Nombres + " ";
  document.getElementById('infoApe').innerHTML = " " + p.Apellidos + " ";
  document.getElementById('infoRol').innerHTML = " " + p.Rol.toUpperCase(); + " ";
  document.getElementById('infoCed').innerHTML = " " + p.Cedula + " ";
  document.getElementById('infoGen').innerHTML = " " + p.Genero + " ";
  document.getElementById('infoCor').innerHTML = " " + p.Email + " ";
  document.getElementById('infoFun').innerHTML = " " + p.Funcion + " ";
  document.getElementById('infoCar').innerHTML = " " + p.Cargo + " ";
  document.getElementById('infoDir').innerHTML = " " + p.Direccion + " ";
  document.getElementById('infoTel').innerHTML = " " + tele + " ";
  document.getElementById('infoMva').innerHTML = " " + monthNames[p.mes_licencia - 1] + " ";
  document.getElementById('infoDia').innerHTML = " " + p.dias_licencia + " ";

  if (p.Estado === 'activo')
    estadoSpan.className = 'lighten-5 green green-text text-accent-4';
  else
    estadoSpan.className = 'lighten-5 pink pink-text text-accent-2';

  p2 = dataSol.filter(x => x.Id_Usuario == data && (x.Id_estado === '3' || x.Id_estado === '5'));
  $('#permCollap').html(html);

  if (p2.length > 0) {
    p2.map(function (x) {
      var starttime = new Date(x.FechaInicio);
      var endtime = new Date(x.FechaFin);
      var estado = estProceso(starttime, endtime);
      var lugar = (x.Lugar) ? x.Hace_Uso + " - " + x.Lugar : x.Hace_Uso
      var Fpresen = (x.FechaPresentacion) ? x.FechaPresentacion : '....';
      html = "<li> \
              <div class='collapsible-header'>\
                <span>Permiso: "+ x.Tipo + "</span>\
                "+ estado + "\
                <i class='material-icons caret right'>keyboard_arrow_right</i>\
              </div> \
              <div class='collapsible-body'>\
                <div class='collection-item'>\
                  <span><b>Motivo:</b></span>&nbsp;<span>"+ x.Descripcion + "</span>&nbsp;&nbsp;&nbsp;&nbsp;\
                  <span><b>Lugar:</b></span>&nbsp;<span>"+ lugar + "</span>&nbsp;&nbsp;&nbsp;&nbsp; <br>\
                  <span><b>Descripción:</b></span>&nbsp;<span>"+ x.Articulo + "</span>&nbsp;&nbsp;&nbsp;&nbsp;\
                  <span><b>Detalle:</b></span>&nbsp;<span>"+ x.detalle_breve + "</span>&nbsp;&nbsp;&nbsp;&nbsp;<br>\
                  <span><b>Fecha de Inicio:</b></span>&nbsp;<span>"+ x.FechaInicio + "</span>&nbsp;&nbsp;&nbsp;&nbsp;\
                  <span><b>Fecha de Fin:</b></span>&nbsp;<span>"+ x.FechaFin + "</span>&nbsp;&nbsp;&nbsp;&nbsp;<br>\
                  <span><b>Fecha de Presentacion:</b></span>&nbsp;<span>"+ Fpresen + "</span>\
                </div>\
              </div>\
          </li>";
      $('#permCollap').append(html);
    });
  } else {
    html = "<li> \
            <div class='collapsible-header'>\
              <span>No contiene permiso</span>\
            </div> \
        </li>";
    $('#permCollap').append(html);
  }

  $('#modalInfo').modal();
  $('#modalInfo').modal('open');
}

function estProceso(diaIni, diaFin) {
  let acttime = new Date();
  endtime = new Date(Date.parse(diaFin) + 1 * 29 * 60 * 60 * 1000);
  starttime = new Date(Date.parse(diaIni) + 1 * 5 * 60 * 60 * 1000);

  if (endtime >= acttime && starttime <= acttime) {
    return "<span class='green-text text-darken-2'> En Proceso </span> ";
  } else if (endtime < acttime && starttime < acttime) {
    return "<span class='red-text text-darken-2'> Culminado </span> ";
  } else if (starttime > acttime) {
    return "<span class='yellow-text text-darken-2'> Por Comenzar </span>";
  }

}

function rolPersona(data) {
  p = next_load.find(x => x.Id_Usuario == data);
  p2 = dataSol.find(x => x.Id_Usuario == data && x.Id_estado === '3');
  var c = cargos.find(x => x.Nombre == p.Cargo);

  var element = document.getElementById("pEscEst"); element.className = "";
  document.getElementById('editAdmin').removeAttribute("disabled");
  $('#pAdmin').attr('checked', true);
  if (p.Rol != 'admin') { $('#pAdmin').attr('checked', false); }

  document.getElementById('pAdmin').setAttribute("disabled", true);
  setSelectedIndex(document.getElementById("cargo1"), c.Id_cargo);
  element.innerHTML = p.Estado;
  document.getElementById('pEscCed').innerHTML = p.Cedula;
  document.getElementById('pEscNom').innerHTML = p.Nombres + " " + p.Apellidos;
  document.getElementById('upd_email').value = p.Email;
  document.getElementById('upd_funci').value = p.Funcion;
  document.getElementById('upd_addre').value = p.Direccion;
  document.getElementById('upd_telef').value = p.Telefono;
  document.getElementById('cargo1').disabled = true;
  $("#upd_addre").prop('disabled', true);
  $("#upd_telef").prop('disabled', true);
  $("#upd_email").prop('disabled', true);
  $("#upd_funci").prop('disabled', true);
  document.getElementById('updtAdmin').innerHTML = 'mode_edit';
  document.getElementById("editAdmin").className = 'btn-smTodo btn-floating red';
  $('#btn_hab').show();
  $('#btnupdPersona').hide();
  if (p.Estado === 'activo') {
    element.className = "badge lighten-5 green green-text text-accent-4 ";
  } else if (p.Estado === 'inactivo') {
    document.getElementById('btn_hab').setAttribute("disabled", true)
    document.getElementById('editAdmin').setAttribute("disabled", true)
    element.className = "badge lighten-5 pink pink-text text-accent-2 ";
  }

  $('select').material_select();
  $('#modal1').modal();
  $('#modal1').modal('open');
}

function editEstado(id) {
  var table = $('#datatable').DataTable();
  if (id == 0 && p.Estado === 'inactivo') {
    console.log('No hubo cambio para estado inactivo');
  } else if (id == 0 && p.Estado === 'activo') {
    console.log('cambio de estado activo a inactivo');
    var r = confirm("Actualizar dato?");
    if (r == true) {
      $.ajax({
        url: 'class/Persona.php',
        method: 'POST',
        data: { id: p.Id_Usuario, estado: 'inactivo', action: 'updtEstado' },
        success: function (data) {
          var data = JSON.parse(data);
          if (data.status == "400") {
            $('#modal1').modal('close');
            tablaPersona();
            table.ajax.reload();
            Materialize.toast('Dato actualizado', 4000, 'green accent-4');
          } else if (data.status == "200") {
            Materialize.toast('Error: ' + data.msg, 4000, 'red lighten-2');
          }
        },
        error: function (data) {
          Materialize.toast(data, 2000);
        },
      });
    }
  } else if (id == 1 && p.Estado === 'activo') {
    console.log('No hubo cambio para estado activo');
  } else if (id == 1 && p.Estado === 'inactivo') {
    console.log('cambio de estado inactivo a activo');
    var r = confirm("Actualizar dato?");
    if (r == true) {
      $.ajax({
        url: 'class/Persona.php',
        method: 'POST',
        data: { id: p.Id_Usuario, estado: 'activo', action: 'updtEstado' },
        success: function (data) {
          var data = JSON.parse(data);
          if (data.status == "400") {
            $('#modal1').modal('close');
            tablaPersona();
            table.ajax.reload();
            Materialize.toast('Dato actualizado', 4000, 'green accent-4');
          } else if (data.status == "200") {
            Materialize.toast('Error: ' + data.msg, 4000, 'red lighten-2');
          }
        },
        error: function (data) {
          Materialize.toast(data, 2000);
        },
      });
    }
  }
}

function editRol() {
  var table = $('#datatable').DataTable();
  var checkBox = document.getElementById("pAdmin");
  if (document.getElementById('pAdmin').disabled == true) {
    document.getElementById('updtAdmin').innerHTML = 'check_circle'; document.getElementById('pAdmin').removeAttribute("disabled");
    var element = document.getElementById("editAdmin"); element.classList.remove("red"); element.classList.add("green");
  } else {
    if (checkBox.checked == true && p.Rol === 'admin' || checkBox.checked == false && p.Rol === 'usuario') {
      Materialize.toast('No hubo cambios', 4000);
    } else {
      var r = confirm("Actualizar dato?");
      var roles = (p.Rol === 'usuario') ? '1' : '2';
      if (r == true) {
        $.ajax({
          url: 'class/Persona.php',
          method: 'POST',
          data: { rol: roles, id: p.Id_Usuario, action: 'updtAdmin' },
          success: function (data) {
            var data = JSON.parse(data);
            if (data.status == "400") {
              Materialize.toast('Dato actualizado', 4000, 'green accent-4');
              tablaPersona(); table.ajax.reload();
            } else if (data.status == "200") {
              Materialize.toast('Error: ' + data.msg, 4000, 'red lighten-2');
            }
          },
          error: function (data) {
            Materialize.toast(data, 2000);
          },
        });
      }else{
        $('#modal1').modal('close');
      }
    }
    document.getElementById('pAdmin').disabled = true; document.getElementById('updtAdmin').innerHTML = 'mode_edit';
    var element = document.getElementById("editAdmin"); element.classList.remove("green"); element.classList.add("red");
  }
}

function editCargo() {
  // var table = $('#datatable').DataTable();
  // if (document.getElementById('cargo1').disabled == true) {
  //   document.getElementById('cargo1').disabled = false;
  //   document.getElementById('updCargo').innerHTML = 'check_circle';
  //   $('select').material_select();
  //   var element = document.getElementById("editCargo"); element.classList.remove("red"); element.classList.add("green");
  // } else {
  //   var c = cargos.find(x => x.Nombre == p.Cargo)
  //   if ($('#cargo1').val() == c.Id_cargo) {
  //     Materialize.toast('No hubo cambios', 4000);
  //   } else {
  //     var r = confirm("Actualizar dato?");
  //     if (r == true) {
  //       $.ajax({
  //         url: 'class/Persona.php', method: 'POST', data: { id: $('#cargo1').val(), cedula: p.Cedula, action: 'updtCargo' },
  //         success: function (data) {
  //           var data = JSON.parse(data);
  //           if (data.status == "400") {
  //             Materialize.toast('Dato actualizado', 4000, 'green accent-4'); tablaPersona(); table.ajax.reload();
  //           } else if (data.status == "200") {
  //             Materialize.toast('Error: ' + data.msg, 4000, 'red lighten-2');
  //           }
  //         }, error: function (data) { Materialize.toast(data, 2000); },
  //       });
  //     }
  //   }
  //   setSelectedIndex(document.getElementById("cargo1"), $('#cargo1').val());
  //   document.getElementById('cargo1').disabled = true; document.getElementById('updCargo').innerHTML = 'mode_edit'; $('select').material_select();
  //   var element = document.getElementById("editCargo"); element.classList.remove("green"); element.classList.add("red");
  // }
}

function validar() {
  var cad = document.getElementById("cedula").value.trim()
  var total = 0;
  var longitud = cad.length;
  var longcheck = longitud - 1;

  if (cad !== "" && longitud === 10) {
    for (i = 0; i < longcheck; i++) {
      if (i % 2 === 0) {
        var aux = cad.charAt(i) * 2;
        if (aux > 9) aux -= 9;
        total += aux;
      } else {
        total += parseInt(cad.charAt(i)); // parseInt o concatenará en lugar de sumar
      }
    }

    total = total % 10 ? 10 - total % 10 : 0;
    if (cad.charAt(longitud - 1) == total) {
      return true;
    } else {
      Materialize.toast('Ingrese Cedula Correcta', 5000, 'purple darken-2');
    }
  } else {
    Materialize.toast('Ingrese Cedula Correcta', 5000, 'purple darken-2');
  }
}

function infoSolicitud() {
  $.ajax({
    url: 'class/Solicitud.php',
    method: 'POST',
    data: { action: 'getSolicitudesAll' },
    success: function (data) { dataSol = JSON.parse(data); }
  });
}

function sendNotifi(id) {
  p = next_load.find(x => x.Id_Usuario == id);
  p2 = dataSol.find(x => x.Id_Usuario == id && x.Id_estado === '3');

  var starttime = (p2) ? new Date(p2.FechaInicio) : new Date('1997-01-01');
  var endtime = (p2) ? new Date(p2.FechaFin) : new Date('1997-01-01');

  let acttime = new Date();
  endtime = new Date(Date.parse(endtime) + 1 * 29 * 60 * 60 * 1000);
  starttime = new Date(Date.parse(starttime) + 1 * 5 * 60 * 60 * 1000);

  let isoDate = new Date(acttime.getTime() - (acttime.getTimezoneOffset() * 60000)).toISOString();
  var today = isoDate.split('T')[0];
  var form = document.getElementById('modalComentario');

  if (p.Estado === 'activo') {
    if (endtime >= acttime && starttime <= acttime) {
      Materialize.toast('Usuario contiene un permiso activo', 4000, 'red lighten-2');
    } else {
      $('#modal5').modal(); $('#modal5').modal('open');
      document.getElementById('pUserNot').innerHTML = p.Nombres + ' ' + p.Apellidos;
      document.getElementsByName("fecha1")[0].setAttribute('min', today);
      form.onsubmit = function (e) {
        e.preventDefault();
        let d = new Date();
        d = ['0' + d.getHours(), '0' + d.getMinutes(), '0' + d.getSeconds(), '0' + d.getDate(), '0' + (d.getMonth() + 1),].map(component => component.slice(-2)); // get hour and date (HHMMSSDDMMYYYY)
        var idP = id + d.slice(0, 3).join('') + d.slice(3).join('') + new Date().getFullYear();
        var coment = form.querySelector('#textarea1').value
        var fecha1 = form.querySelector('#fecha1').value
        var hora1 = form.querySelector('#hora1').value
        var lugar = form.querySelector('#lugar').value
        var tipo = form.querySelector('#tipo').value
        var idA = 1; var idE = 6; var idT = 1; var haceUso = '';
        var body = 'Estimado ' + p.Nombres + ' ' + p.Apellidos + ': Se le notifica por el Asunto de ' + coment + ' - ' + tipo + ', el dia ' + fecha1 + ' a las ' + hora1 + ' en ' + lugar + '. Gracias.'
        coment += '  --  ' + fecha1 + ' ' + hora1 + ''
        document.getElementById("envNotif").disabled = true;
        $.ajax({
          url: 'class/Solicitud.php',
          method: 'POST',
          data: {
            Id_Permisos: idP, Detalle: new Date(isoDate).toISOString().slice(0, 19).replace('T', ' '), Id_Usuario: id, FechaInicio: fecha1, Descripcion: tipo, Comentario: coment, Id_Estado: idE,
            Id_Tipo: idT, Hace_Uso: haceUso, Lugar: lugar, id_articulo: idA, body: body, action: 'NotificaPer'
          },
          success: function (data) {
            var data = JSON.parse(data);
            if (data.status == "400") {
              Materialize.toast('Notificacion enviada', 4000, 'green accent-4');
            } else if (data.status == "200") {
              Materialize.toast('Error: ' + data.msg, 4000, 'red lighten-2');
            }
          },
          error: function (data) {
            Materialize.toast(data, 2000);
          },
          complete: function () {
            $('#modal5').modal('close');
            document.getElementById("envNotif").disabled = false;
            document.getElementById("modalComentario").reset();
          },
        });
      };
    }
  }
  else {
    Materialize.toast('Usuario no activo', 4000, 'red lighten-2');
  }
}