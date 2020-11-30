var soli = null;
Notification.requestPermission();

var interval = setInterval(function () {
    $.ajax({
        url: "class/Solicitud.php",
        type: "POST",
        data: { action: 'getSolicitudes' },
        success: function (data) {
            var data1 = JSON.parse(data);
            if (data1.data.length != 0) {
                if (soli == null) {
                    soli = data1.data.length;
                }
                else if (soli > data1.data.length) {
                    soli = data1.data.length;
                }
                else if (soli < data1.data.length) {
                    prueba_notificacion();
                    soli = data1.data.length;
                }
            } else {
                soli = data1.data.length;
            }
        }
    });
}, 10000);



function prueba_notificacion() {
    if (Notification) {
        if (Notification.permission !== "granted") {
            Notification.requestPermission()
        }
        var title = "SICEO"
        var extra = {
            icon: "resources/img/Siceo_not.png",
            body: "Nueva solicitud"
        }
        var noti = new Notification(title, extra)

        noti.onclick = function (event) {
            event.preventDefault(); // Previene al buscador de mover el foco a la pestaña del Notification
            window.open('index.php?menu=solicitudes', '_blank');
        }
        setTimeout(function () { noti.close() }, 20000)
    }

}

var session = setInterval(function () {
    $.ajax({
        url: "class/check_session.php",
        method: "POST",
        success: function (data) {
            if (data == '1') {
                alert('Su sesion ha expirado!');
                window.location.href = "index.php";
            }
        }
    });
}, 10000);  //10000 means 10 seconds

function data() {
    $.ajax({
        url: 'class/Persona.php',
        method: 'POST',
        data: {
            action: 'agregaTodos',
        },
        error: function (data) {
            console.log(data);
            Materialize.toast(data, 2000);
        },
    });
}

