var result = [];
var p = [];
var timeinterval;

function getTimeRemaining(endtime) {
    var t = Date.parse(endtime) - Date.parse(new Date());
    var seconds = Math.floor((t / 1000) % 60);
    var minutes = Math.floor((t / 1000 / 60) % 60);
    var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
    var days = Math.floor(t / (1000 * 60 * 60 * 24));
    return {
        'total': t,
        'days': days,
        'hours': hours,
        'minutes': minutes,
        'seconds': seconds
    };
}

function infoSolicitud() {
    $.ajax({
        url: 'class/Solicitud.php',
        method: 'POST',
        data: { action: 'getSolicitudesAll' },
        success: function (data) { result = JSON.parse(data); }
    });
}

function inforDene(id) {
    $('#modal3').modal('open');
    p = result.find(x => x.Id_Permisos == id);
    var infor = document.getElementById('informacion1');
    infor.querySelector('#pEscCed1').innerHTML = p.Cedula;
    infor.querySelector('#pEscNom1').innerHTML = p.Nombres;
    infor.querySelector('#pEscTipo1').innerHTML = p.Tipo;
    infor.querySelector('#pEscDesc1').innerHTML = p.Descripcion;
    infor.querySelector('#pEscLuga1').innerHTML = p.Lugar;
    document.getElementById('pcomentario').innerHTML = p.Comentario;
}

function infoAcep(id) {
    $('#modal2').modal('open');
    clearInterval(timeinterval);
    p = result.find(x => x.Id_Permisos == id);
    var starttime = new Date(p.FechaInicio);
    var endtime = new Date(p.FechaFin);
    var clock = document.getElementById('clockdiv');
    var daysSpan = clock.querySelector('.days');
    var hoursSpan = clock.querySelector('.hours');
    var minutesSpan = clock.querySelector('.minutes');
    var secondsSpan = clock.querySelector('.seconds');
    endtime = new Date(Date.parse(endtime) + 1 * 29 * 60 * 60 * 1000);
    starttime = new Date(Date.parse(starttime) + 1 * 5 * 60 * 60 * 1000);
    var infor = document.getElementById('informacion');
    infor.querySelector('#pEscCed').innerHTML = p.Cedula;
    infor.querySelector('#pEscNom').innerHTML = p.Nombres;
    infor.querySelector('#pEscTipo').innerHTML = p.Tipo;
    infor.querySelector('#pEscDesc').innerHTML = p.Descripcion;
    infor.querySelector('#pEscLuga').innerHTML = p.Lugar;

    updateClock();
    timeinterval = setInterval(updateClock, 1000);

    var options = { year: 'numeric', month: 'long', day: 'numeric' };

    if (endtime >= new Date() && starttime <= new Date()) {
        $('#clockdiv').show();
        document.getElementById('infoAdic').innerHTML = "El permiso esta en proceso";
    } else if (endtime < new Date() && starttime < new Date()) {
        $('#clockdiv').show();
        // $('#clockdiv').hide();
        document.getElementById('infoAdic').innerHTML = "El permiso ha culmidado<br />  " + endtime.toLocaleDateString("es-ES", options);
        // clearInterval(timeinterval);
    } else if (starttime > new Date()) {
        $('#clockdiv').hide();
        document.getElementById('infoAdic').innerHTML = "El permiso no ha comenzado <br /> <br /> <br /> Comenzara el dia: " + starttime.toLocaleDateString("es-ES", options);
        // clearInterval(timeinterval);
    }

    function updateClock() {
        var t = getTimeRemaining(endtime);
        daysSpan.innerHTML = t.days;
        hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
        minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
        secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);
        if (t.total <= 0) {
            clearInterval(timeinterval);
        }
    }

    $('#cierrahilo').click(function () {
        clearInterval(timeinterval);
    });

}


$(document).ready(function () {
    $('.modal').modal();
    $('.tabs').tabs();
    $('input#input_text, textarea#textarea1').characterCounter();
    window.onload = infoSolicitud();

    $('.tabs').click(function () {
        $.fn.dataTable.tables({ visible: true, api: true })
            .columns.adjust().draw();
    });
    $('.search-toggle').click(function () {
        if ($('.hiddensearch').css('display') == 'none')
            $('.hiddensearch').slideDown();
        else
            $('.hiddensearch').slideUp();
    });



    var table1 = $('#tbl_solicitudes').DataTable({
        "ajax": {
            "url": "class/Solicitud.php",
            "type": "POST",
            data: { action: 'getSolicitudes' },
        },
        "columns": [
            { "data": "cedula" },
            { "data": "name" },
            { "data": "tipo" },
            { "data": "desc" },
            { "data": "enviado" },
            { "data": "fechas" },
            { "data": "acciones" },
        ],
        buttons: [
            {
                text: '<span style="color:#4d4d4d;">Imprmir<span>',
                extend: 'print',
                className: '',
                title: '',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                },
                customize: function (win) {
                    $(win.document.body)
                        .css('font-size', '10pt')
                        .prepend(
                            '<br/><br/><br/><br/><br/><br/><br/><h4 style="text-align: center;">Solicitudes Recibidas</h4>',
                        );
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            { text: '<span style="color:#4d4d4d;">Csv<span>', extend: 'csvHtml5', },
            { text: '<span style="color:#4d4d4d;">Recargar<span>', action: function (e, dt, node, config) { dt.ajax.reload(); infoSolicitud(); } },
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
            "sLengthMenu": '<span>Ver:</span><select class="browser-default">' +
                '<option value="10">10</option>' +
                '<option value="20">20</option>' +
                '<option value="30">30</option>' +
                '<option value="40">40</option>' +
                '<option value="50">50</option>' +
                '<option value="-1">Todo</option>' +
                '</select></div>',
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        dom: "<'hiddensearch'f'>" + "tr" + "<'table-footer'Blip'>",
        renderer: 'material',
        responsive: true,
        "bAutoWidth": false,
        "bDeferRender": true,
        "pagingType": "full",
        "scrollY": "360px",
        "scrollCollapse": true,
    });

    var table2 = $('#tbl_solicitudes_acep').DataTable({
        "ajax": {
            "url": "class/Solicitud.php",
            "type": "POST",
            data: { action: 'getSolicitudesAcep' },
        },
        "columns": [
            { "data": "cedula" },
            { "data": "name" },
            { "data": "tipo" },
            { "data": "desc" },
            { "data": "fechas" },
            { "data": "est" },
            { "data": "opc" },
        ],
        "createdRow": function (row, data, dataIndex) {
            if (data['days'] <= 1) {
                $(row).addClass('redrowClass');
            }
        },
        buttons: [
            { text: '<span style="color:#4d4d4d;">Recargar<span>', action: function (e, dt, node, config) { dt.ajax.reload(); } }
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
            "sLengthMenu": '<span>Ver:</span><select class="browser-default">' +
                '<option value="10">10</option>' +
                '<option value="20">20</option>' +
                '<option value="30">30</option>' +
                '<option value="40">40</option>' +
                '<option value="50">50</option>' +
                '<option value="-1">Todo</option>' +
                '</select></div>',
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        dom: "<'hiddensearch'f'>" + "tr" + "<'table-footer'Blip'>",
        renderer: 'material',
        responsive: true,
        "bAutoWidth": false,
        "bDeferRender": true,
        "pagingType": "full",
        "scrollY": "360px",
        "scrollCollapse": true,
    });

    var table3 = $('#tbl_solicitudes_denegadas').DataTable({
        "ajax": {
            "url": "class/Solicitud.php",
            "type": "POST",
            data: { action: 'getSolicitudesDeneg' },
        },
        "columns": [
            { "data": "cedula" },
            { "data": "name" },
            { "data": "tipo" },
            { "data": "desc" },
            { "data": "fechas" },
            { "data": "opc" },
        ],
        buttons: [
            { text: '<span style="color:#4d4d4d;">Recargar<span>', action: function (e, dt, node, config) { dt.ajax.reload(); } }
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
            "sLengthMenu": '<span>Ver:</span><select class="browser-default">' +
                '<option value="10">10</option>' +
                '<option value="20">20</option>' +
                '<option value="30">30</option>' +
                '<option value="40">40</option>' +
                '<option value="50">50</option>' +
                '<option value="-1">Todo</option>' +
                '</select></div>',
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        dom: "<'hiddensearch'f'>" + "tr" + "<'table-footer'Blip'>",
        renderer: 'material',
        responsive: true,
        "bAutoWidth": false,
        "bDeferRender": true,
        "pagingType": "full",
        "scrollY": "360px",
        "scrollCollapse": true,
    });

    var table4 = $('#tbl_notifaciones').DataTable({
        "ajax": {
            "url": "class/Solicitud.php",
            "type": "POST",
            data: { action: 'getNotificacion' },
            "dataSrc": function (json) {
                var data = json.map((row) => {
                    return [row.Cedula, row.Nombres, row.Descripcion, row.Enviado, row.Lugar, row.Comentario];
                });
                return data;
            }
        },
        buttons: [
            { text: '<span style="color:#4d4d4d;">Recargar<span>', action: function (e, dt, node, config) { dt.ajax.reload(); } }
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
            "sLengthMenu": '<span>Ver:</span><select class="browser-default">' +
                '<option value="10">10</option>' +
                '<option value="20">20</option>' +
                '<option value="30">30</option>' +
                '<option value="40">40</option>' +
                '<option value="50">50</option>' +
                '<option value="-1">Todo</option>' +
                '</select></div>',
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        dom: "<'hiddensearch'f'>" + "tr" + "<'table-footer'Blip'>",
        renderer: 'material',
        responsive: true,
        "bAutoWidth": false,
        "bDeferRender": true,
        "pagingType": "full",
        "scrollY": "360px",
        "scrollCollapse": true,
    });

    var table4 = $('#tbl_solicitudes_culminado').DataTable({
        "ajax": {
            "url": "class/Solicitud.php",
            "type": "POST",
            data: { action: 'getSolicitudesCulmin' },
        },
        "columns": [
            { "data": "cedula" },
            { "data": "name" },
            { "data": "tipo" },
            { "data": "desc" },
            { "data": "fechas" },
            { "data": "fechaP" },
            { "data": "opc" },
        ],
        buttons: [
            { text: '<span style="color:#4d4d4d;">Recargar<span>', action: function (e, dt, node, config) { dt.ajax.reload(); } }
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
            "sLengthMenu": '<span>Ver:</span><select class="browser-default">' +
                '<option value="10">10</option>' +
                '<option value="20">20</option>' +
                '<option value="30">30</option>' +
                '<option value="40">40</option>' +
                '<option value="50">50</option>' +
                '<option value="-1">Todo</option>' +
                '</select></div>',
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        dom: "<'hiddensearch'f'>" + "tr" + "<'table-footer'Blip'>",
        renderer: 'material',
        responsive: true,
        "bAutoWidth": false,
        "bDeferRender": true,
        "pagingType": "full",
        "scrollY": "360px",
        "scrollCollapse": true,
    });
});


function aceptarSolicitud(id) {
    var table = $('#tbl_solicitudes').DataTable();
    var table1 = $('#tbl_solicitudes_acep').DataTable();
    p = result.find(x => x.Id_Permisos == id);
    var r = confirm("Desea aceptar la solicitud");
    if (r == true) {
        $.ajax({
            url: 'class/Solicitud.php',
            method: 'POST',
            data: { pers: p, action: 'acepta' },
            success: function (data) {
                var data = JSON.parse(data);
                if (data.status == "400") {
                    Materialize.toast('Solicitud aceptada', 4000, 'green accent-4');
                    table.ajax.reload(); table1.ajax.reload(); infoSolicitud();
                } else if (data.status == "200") {
                    Materialize.toast('Error: ' + data.msg, 4000, 'red lighten-2');
                }
            },
            error: function (data) {
                var data = JSON.parse(data);
                Materialize.toast(data.msg, 2000);
            },
        });
    }
}

function niegaSolicitud(id) {
    var table = $('#tbl_solicitudes').DataTable();
    var table1 = $('#tbl_solicitudes_denegadas').DataTable();
    p = result.find(x => x.Id_Permisos == id);

    var r = confirm("Desea negar la solicitud");
    if (r == true) {
        $('#modal5').modal('open');
    }

    var form = document.getElementById('modalComentario');
    form.onsubmit = function (e) {
        e.preventDefault();
        coment = form.querySelector('#textarea1').value
        $.ajax({
            url: 'class/Solicitud.php',
            method: 'POST',
            data: { coment: coment, pers: p, action: 'niega' },
            success: function (data) {
                var data = JSON.parse(data);
                if (data.status == "400") {

                    Materialize.toast('Solicitud denegada', 4000, 'green accent-4');
                } else if (data.status == "200") {
                    Materialize.toast('Error: ' + data.msg, 4000, 'red lighten-2');
                }
            },
            error: function (data) {
                Materialize.toast(data, 2000);
            },
            complete: function () {
                $('#modal5').modal('close');
                infoSolicitud();
                document.getElementById("modalComentario").reset();
                table.ajax.reload(); table1.ajax.reload();
            },
        });
    };

}

function userPresen(id){
    p = result.find(x => x.Id_Permisos == id);
    var starttime = new Date(p.FechaInicio);
    var endtime = new Date(p.FechaFin);
    let acttime = new Date();
    let isoDate = new Date(acttime.getTime() - (acttime.getTimezoneOffset() * 60000)).toISOString();
    var today = isoDate.split('T')[0];
    endtime = new Date(Date.parse(endtime) + 1 * 29 * 60 * 60 * 1000);
    starttime = new Date(Date.parse(starttime) + 1 * 5 * 60 * 60 * 1000);
    var table = $('#tbl_solicitudes_acep').DataTable();    
    var tableCul = $('#tbl_solicitudes_culminado').DataTable();  
    var options = { year: 'numeric', month: 'long', day: 'numeric' };
    if (endtime >= acttime && starttime <= acttime) {
        document.getElementById('infoAdic').innerHTML = "El permiso esta en proceso";
        Materialize.toast('El permiso aun esta proceso ', 4000);
    } else if (endtime < acttime && starttime < acttime) {
        var r = confirm("Confirmar dia de presentacion de: "+p.Nombres+", hoy "+acttime.toLocaleDateString("es-ES", options));
        if (r == true) {
            $.ajax({
                url: 'class/Solicitud.php',
                method: 'POST',
                data: { pers: p, diaP: today, action: 'updPresentPermiso' },
                success: function (data) {
                    var data = JSON.parse(data);
                    if (data.status == "400") {
                        Materialize.toast('Permiso culminado', 4000, 'green accent-4');
                        table.ajax.reload(); tableCul.ajax.reload(); infoSolicitud();
                    } else if (data.status == "200") {
                        Materialize.toast('Error: ' + data.msg, 4000, 'red lighten-2');
                    }
                },
                error: function (data) {
                    var data = JSON.parse(data);
                    Materialize.toast(data.msg, 2000);
                },
            });
        }

    } else if (starttime > acttime) {
        Materialize.toast('El permiso aun no comienza', 4000);
    }
}

function viewPdf(id) {
    $('#modal4').modal('open');
    var url = decodeURIComponent("ArchivosPhp/generar_pdf.php?id=" + id);
    PDFObject.embed(url, "#example1");
}