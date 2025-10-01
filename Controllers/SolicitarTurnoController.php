<?php
header('Content-Type: application/json');
require "../Models/SolicitarTurno.php";

class SolicitarTurnoController
{
    //HACE LLAMADO DEL TURNO
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





    // FUNCION QUE HACE EL LLAMADO AL TURNO
    public function LlamarTurno()
    {
        $contador = $_POST['contador'] ?? '';
        $ventanilla = $_POST['ventanilla'] ?? '';
        $model = new SolicitarTurno();
        $result = $model->categoria($ventanilla); // ← categoría real de la ventanilla

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
        if (empty($result["categoria1"]) and empty($result["categoria2"])) {
            echo json_encode([
                "status" => "error",
                "msg" => "no tienes ninguna categoria PIDELE AL ADMINISTRADOR QUE TE AGREGE CATEGORIAS",
                "data" => null
            ]);
            exit;
        } else {
            foreach ($turnos as $i => $t) {
                if ($contador < 2) {
                    if ($t["categoria"] === $result["categoria1"]) {
                        $indiceEliminar = $i;
                        break;
                    }
                } else {
                    if ($t["categoria"] === $result["categoria2"]) {
                        $indiceEliminar = $i;
                        break;
                    }
                }
            }
        }

        if ($indiceEliminar === null || $indiceEliminar == "undefined") {
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

        // Guardar turno llamado antes de eliminar
        $turnoLlamado = $turnos[$indiceEliminar];

        // Eliminar turno del archivo original
        unset($turnos[$indiceEliminar]);
        $turnos = array_values($turnos);
        file_put_contents($file, json_encode($turnos, JSON_PRETTY_PRINT));

        // Aquí llamamos a tu función Turnollamado (guardará en turnosllamados.json)
        $this->Turnollamado($turnoLlamado, $ventanilla);

        echo json_encode([
            "status" => "ok",
            "msg" => "Turno llamado correctamente",
            "data" => $turnoLlamado
        ]);
        exit;
    }








    //ESTE ES PARA QUE EL ADMINISTRADOR LLAME TURNOS SIN NECESIDAD QUE EL FACTURADOR LO HAGA

    function llamarTurnoAdmin()
    {
        $turnoLlamado = $_POST["turno"] ?? null;
        $usuario = $_POST["usuario"] ?? null;

        if (!$turnoLlamado || !$usuario) {
            echo json_encode([
                "status" => "error",
                "msg" => "Datos incompletos"
            ]);
            return;
        }

        $file = __DIR__ . "/../data/turnos.json";

        if (!file_exists($file)) {
            echo json_encode([
                "status" => "error",
                "msg" => "No existe el archivo de turnos"
            ]);
            return;
        }

        $turnos = json_decode(file_get_contents($file), true);

        if (empty($turnos)) {
            echo json_encode([
                "status" => "error",
                "msg" => "No hay turnos registrados"
            ]);
            return;
        }

        // 1. Buscar el turno con su categoría
        $turnoSeleccionado = null;
        foreach ($turnos as $t) {
            if (intval($t["turno"]) === intval($turnoLlamado)) {
                $turnoSeleccionado = $t; // aquí ya tengo categoria + turno
                break;
            }
        }

        if (!$turnoSeleccionado) {
            echo json_encode([
                "status" => "error",
                "msg" => "Turno no encontrado"
            ]);
            return;
        }

        // 2. Filtrar y eliminar el turno
        $nuevoArray = array_filter($turnos, function ($t) use ($turnoLlamado) {
            return intval($t["turno"]) !== intval($turnoLlamado);
        });

        // Reindexar y guardar
        file_put_contents($file, json_encode(array_values($nuevoArray), JSON_PRETTY_PRINT));

        // 3. Llamar a Turnollamado enviando categoria, turno y usuario
        $model = new SolicitarTurnoController();
        $model->Turnollamado($turnoSeleccionado, $usuario);

        echo json_encode([
            "status" => "ok",
            "msg" => "Turno {$turnoLlamado} llamado y eliminado correctamente",
            "turno" => $turnoSeleccionado
        ]);
    }







    // ENVIAMOS LA INFORMACION A TURNOSLLAMADOS.JSON PARA QUE EL REFLEJE EN PANTALLA 
    //LO QUE NOSOTROS LLAMAMOS

    function Turnollamado($turno, $usuario)
    {
        $file = __DIR__ . "/../data/turnosllamados.json";

        // Si no existe el archivo, iniciamos vacío
        $turnosLlamados = [];
        if (file_exists($file)) {
            $contenido = file_get_contents($file);
            $turnosLlamados = json_decode($contenido, true) ?? [];
        }

        // Armar el nuevo turno
        $nuevoTurno = [
            "categoria"  => $turno["categoria"],
            "turno"      => $turno["turno"],
            "ventanilla" => $usuario
        ];

        // Agregar al final
        $turnosLlamados[] = $nuevoTurno;

        // Mantener máximo 15 → si hay más de 15, eliminar el primero
        if (count($turnosLlamados) > 15) {
            array_shift($turnosLlamados); // elimina el más viejo
        }

        // Guardar actualizado
        file_put_contents($file, json_encode($turnosLlamados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return [
            "status" => "ok",
            "msg" => "Turno agregado a turnosllamados.json",
            "turno" => $nuevoTurno
        ];
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
if (isset($_REQUEST['action']) && $_REQUEST['action'] === "llamarTurnoAdmin") {
    $controller = new SolicitarTurnoController();
    $controller->llamarTurnoAdmin();
}
