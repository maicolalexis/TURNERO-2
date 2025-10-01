$("#formLogin").submit(function (e) {
  e.preventDefault(); // 🚫 evita recarga inmediata

  $.ajax({
    url: "index.php?c=usuario&a=autenticar",
    type: "POST",
    data: $(this).serialize(),
    success: function (res) {
      try {
        let respuesta = JSON.parse(res);
        if (respuesta.status === "ok") {
          $("#respuesta").html("<p style='color:green'>" + respuesta.msg + "</p>");
        } else {
          $("#respuesta").html("<p style='color:red'>" + respuesta.msg + "</p>");
        }

        // En ambos casos mostramos "Pensando..." y redirigimos en 5s
        $("#respuesta").append("<p>Pensando...</p>");
        setTimeout(function () {
          window.location.href = "views/llamadosTurnos.php";
        }, 5000);
      } catch (e) {
        console.error("Error parseando JSON:", e, res);
      }
    },
    error: function () {
      $("#respuesta").html("<p style='color:red'>Error en la petición</p>");
      $("#respuesta").append("<p>Pensando...</p>");
      setTimeout(function () {
        location.reload();
      }, 5000);
    }
  });
});


$("#btnTurnoCitaMedica").on("click", function () {
  let categoria = {
    "categoria": "citamedica"
  };
  enviarDatoDelTurno(categoria);
});
$("#btnTurnoCitaMedicaP").on("click", function () {
  let categoria = {
    "categoria": "citamedicap"
  };
  enviarDatoDelTurno(categoria);
});
$("#btnTurnoFacturacion").on("click", function () {
  let categoria = {
    "categoria": "facturacion"
  };
  enviarDatoDelTurno(categoria);
});
$("#btnTurnoFacturacionP").on("click", function () {
  let categoria = {
    "categoria": "facturacionp"
  };
  enviarDatoDelTurno(categoria);
});

function enviarDatoDelTurno(categoria) {
  $.ajax({
    url: "../Controllers/SolicitarTurnoController.php?accion=solicitar",
    type: "POST",
    data: categoria,
    dataType: "json",
    success: function (res) {
      console.log(res)
      if (res.status === "ok") {
        $("#respuesta").html(
          `<p class='text-green-600 font-bold'>${res.msg}</p>
           <p>Categoria: ${res.data.categoria}</p>
           <p>Turno: ${res.data.turno}</p>`
        );
        qz.websocket.connect().then(function () {
          var config = qz.configs.create("Nombre_de_tu_impresora");
          var data = [{
            type: 'raw',
            format: 'plain',
            data: 'Esto es lo que se mandará directo a la impresora\n\n'
          }];
          return qz.print(config, data);
        }).catch(function (e) { console.error(e); });
      } else {
        $("#respuesta").html("<p class='text-red-600'>Error guardando turno</p>");
      }
    },
    error: function () {
      $("#respuesta").html("<p class='text-red-600'>Error en la petición</p>");
    }
  });
}
var contador = 0;
$("#llamarTurno").submit(function (e) {
  e.preventDefault();
  let ventanilla = $("#ventanilla").val();
  if (contador == 2) {
    contador = 0;
  } else {
    contador++;
  }
  let datos = {
    "contador": contador,
    "ventanilla": ventanilla,
  };
  $.ajax({
    url: "../Controllers/SolicitarTurnoController.php?accion=llamarTurno",
    type: "POST",
    data: datos ,
    dataType: "json",
    success: function (res) {
      if (res.status === "ok") {
        $("#respuesta").html(
          `<p class='text-blue-600 font-bold'>${res.msg}</p>
           <p>Categoría: ${res.data.categoria}</p>
           <p>Turno: ${res.data.turno}</p>`

        );
      } else {
        $("#respuesta").html(`<p class='text-red-600'>${res.msg}</p>`);
      }
    }, error: function (xhr, status, error) {
      console.error("Error AJAX:", status, error);
      $("#respuesta").html("<p class='text-red-600'>Error en la petición</p>");
    }
  });
});
// llamar la funcion para que aparezca el select en turnospendientes
$(document).ready(function () {
  if ($("#turnosPage").length) {
    cargarUsuarios();
  }

});
/**
 * Función para cargar usuarios desde el controlador
 */
function cargarUsuarios() {

  $.ajax({
    url: "../Controllers/UsuarioController.php", // el controlador que llama al modelo
    type: "POST", // usamos POST como pediste
    data: { "action": "listar" },
    dataType: "json",
    success: function (res) {

      if (res.status === "ok") {
        let $select = $(".usuarioSelect");
        $select.empty(); // limpiamos el select
        $select.append('<option value="">Selecciona un usuario</option>');

        // recorrer usuarios recibidos
        res.data.forEach(function (ventanilla) {
          $select.append(
            `<option value="${ventanilla.ventanilla}">${ventanilla.ventanilla}</option>`
          );
        });
      } else {
        alert("No se encontraron usuarios.");
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la petición:", error);
      alert("Error al cargar los usuarios.");
    },
  });
}
$(document).on("click", ".btnLlamar", function () {
  let turno = $(this).data("turno"); // turno del botón
  let usuario = $(this).closest("td").find(".usuarioSelect").val(); // usuario del select en la misma fila

  if (!usuario) {
    alert("Debes seleccionar un usuario antes de llamar un turno.");
    return;
  }

  $.ajax({
    url: "../Controllers/SolicitarTurnoController.php",
    type: "POST",
    dataType: "json",
    data: {
      "action": "llamarTurnoAdmin",
      turno: turno,
      usuario: usuario
    },
    success: function (res) {
      if (res.status === "ok") {
        mostrarAlerta("Éxito", res.msg, "success");
      } else {
        mostrarAlerta("Error", res.msg, "error");
      }
    },
    error: function (xhr, status, error) {
      mostrarAlerta("Error", "Error en la petición: " + error, "error");
    }

  });

  function mostrarAlerta(titulo, mensaje, tipo = "info") {
    let $modal = $("#alertaModal");
    let $titulo = $("#alertaTitulo");
    let $mensaje = $("#alertaMensaje");

    // Cambiar colores según tipo
    if (tipo === "success") {
      $titulo.removeClass().addClass("text-lg font-bold mb-2 text-green-600");
    } else if (tipo === "error") {
      $titulo.removeClass().addClass("text-lg font-bold mb-2 text-red-600");
    } else {
      $titulo.removeClass().addClass("text-lg font-bold mb-2 text-blue-600");
    }

    $titulo.text(titulo);
    $mensaje.text(mensaje);
    $modal.removeClass("hidden");
  }

  // Cerrar alerta
  $(document).on("click", "#cerrarAlerta", function () {
  $("#alertaModal").addClass("hidden");

  // Esperar 1 segundo y recargar
  setTimeout(function () {
    location.reload();
  }, 30);
});
})