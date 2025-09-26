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
$("#llamarTurno").submit(function(e) {   
  e.preventDefault();
  if(contador == 2){
    contador = 0;
  }else{
    contador++;
  }
  let cont = {
    "contador": contador
  };
  console.log(contador)
  $.ajax({
    url: "../Controllers/SolicitarTurnoController.php?accion=llamarTurno",
    type: "POST",
    data: cont,
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
    },error: function(xhr, status, error) {
      console.error("Error AJAX:", status, error);
      $("#respuesta").html("<p class='text-red-600'>Error en la petición</p>");
    }
  });
});
