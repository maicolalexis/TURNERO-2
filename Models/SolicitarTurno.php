<?php
require_once "../core/Database.php";
class SolicitarTurno
{

    public function SolicitarTurnos($categoria)
    {
        header('Content-Type: application/json');

        // Archivo donde guardaremos
        $file = __DIR__ . "/../data/turnos.json";

        // Leemos lo que ya hay
        $turnos = [];
        if (file_exists($file)) {
            $turnos = json_decode(file_get_contents($file), true);
            if (!is_array($turnos)) {
                $turnos = [];
            }
        }

        // Obtenemos el turno actual (último + 1)
        $ultimoTurno = 0;
        if (!empty($turnos)) {
            $ultimoTurno = end($turnos)["turno"];
        }

        // Creamos nuevo registro
        $nuevo = [
            "categoria" => $categoria,
            "turno" => $ultimoTurno + 1
        ];

        // Guardamos
        $turnos[] = $nuevo;
        file_put_contents($file, json_encode($turnos, JSON_PRETTY_PRINT));

        // Devolvemos respuesta
        return json_encode([
            "status" => "ok",
            "msg" => "Turno guardado correctamente",
            "data" => $nuevo
        ]);
    }
    public function categoria($ventanilla)
    {
        
        $db = Database::getConexion();

        $stmt = $db->prepare("SELECT categoria FROM ventanillas WHERE ventanilla =? ");
        $stmt->bind_param("s", $ventanilla);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            return $row['categoria']; // 👈 devolver string real
        } else {
            return "error";
        }
    }
}
