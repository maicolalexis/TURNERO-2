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




    //ESTA FUNCION FUE DISEÑADA PARA VERIFICAR LAS CATEGORIAS 
    public function categoria($ventanilla)
    {
        //SE LLAMA LA BASE DE DATOS
        $db = Database::getConexion();
        // SE CREA EL SQL
        $sql = "SELECT c.categoria1, c.categoria2
        FROM ventanillas v
        INNER JOIN categoria c ON v.id = c.id_ventanilla
        WHERE v.ventanilla = ?
    ";
        //PREPARAMOS EL SQL
        $stmt = $db->prepare($sql);

        //SE VERIFICA SI QUEDO BIEN
        if (!$stmt) {
            die("Error en prepare: " . $db->error);
        }
        $stmt->bind_param("s", $ventanilla);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            // HACEMOS UN ARRAY QUE ENVIE LA CATEGORIA1 Y CATEGORIA2
            return [
                "categoria1" => $row['categoria1'],
                "categoria2" => $row['categoria2']
            ];
        } else {
            return [];
        }
    }
    public static function llamarTurnoAdmin($turno, $usuario)
    {
        $db = Database::getConexion();

        // Ejemplo: registrar el turno llamado
        $sql = "INSERT INTO turnos_llamados (turno, usuario, fecha) VALUES (?, ?, NOW())";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("is", $turno, $usuario);

        return $stmt->execute();
    }
}
