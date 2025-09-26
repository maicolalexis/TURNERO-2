<?php
header('Content-Type: application/json');
require "../Models/SolicitarTurno.php";

class SolicitarTurnoController
{
    public function Solicitar()
    {
        $categoria = $_POST['categoria'];
        $model = new SolicitarTurno();
        $user = $model->SolicitarTurnos($categoria);
        $array = json_decode($user, true);

        echo json_encode([
            "status" => $array["status"],
            "msg" => $array["msg"],
            "data" => $array["data"],
        ]);
    }

    // ✅ Ejecutar directamente el método
    public function LlamarTurno()
    {
        $contador = $_POST['contador'] ?? '';
        $ventanilla = $_POST['ventanilla'] ?? '';

        $model = new SolicitarTurno();
        $result = $model->categoria($ventanilla); // ← aquí te devuelve la categoría real

        $file = __DIR__ . "/../data/turnos.json";

        if (!file_exists($file)) {
            echo json_encode([
                "status" => "error",
                "msg" => "No hay turnos registrados",
                "data" => null
            ]);
            exit;
        }

        $turnos = json_decode(file_get_contents($file), true);

        if (empty($turnos)) {
            echo json_encode([
                "status" => "error",
                "msg" => "No hay turnos en espera",
                "data" => null
            ]);
            exit;
        }
        $indiceEliminar = null;
        foreach ($turnos as $i => $t) {
            // Caso normal: coincide con la categoría de la ventanilla
            if ($contador < 2) {
                if ($t["categoria"] === "facturacionp") {
                    $indiceEliminar = $i;
                    break; // Si son 2 turnos de facturación, la próxima vez debe buscar facturación prioritaria
                }
            }else {
            if ($t["categoria"] === "facturacion") {
                $indiceEliminar = $i;
                break; // Si son 2 turnos de facturación, la próxima vez debe buscar facturación prioritaria
            }else{

            }
        }
        }
        if ($indiceEliminar === null or $indiceEliminar == "undefined") {
            echo json_encode([
                "status" => "ok",
                "msg" => "No hay turnos para la categoría: " . $result,
                "data" => [
                    "categoria" => $result,
                    "indiceEliminar" => $indiceEliminar,
                    "turno" => "Debes esperar"
                ]
            ]);
            exit;
        }

        $turnoLlamado = $turnos[$indiceEliminar];

        unset($turnos[$indiceEliminar]);
        $turnos = array_values($turnos);
        file_put_contents($file, json_encode($turnos, JSON_PRETTY_PRINT));

        echo json_encode([
            "status" => "ok",
            "msg" => "Turno llamado correctamente",
            "data" => $turnoLlamado
        ]);
        exit;
    }
}


// 👇 Para permitir acceso directo desde AJAX
if (isset($_REQUEST['accion']) && $_REQUEST['accion'] === "llamarTurno") {
    $controller = new SolicitarTurnoController();
    $controller->llamarTurno();
}
if (isset($_REQUEST['accion']) && $_REQUEST['accion'] === "solicitar") {
    $controller = new SolicitarTurnoController();
    $controller->Solicitar();
}
