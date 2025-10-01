<?php
require_once __DIR__ . '/../core/Database.php';

class Usuario
{
    public function verificar($usuario, $clave)
    {
        $db = Database::getConexion();
        $stmt = $db->prepare("SELECT * FROM ventanillas WHERE ventanilla=? AND contraseña=?");
        $stmt->bind_param("ss", $usuario, $clave);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $usuarios = new Usuario;
            $categoria = $usuarios->categoria($usuario);
            return ["ventanilla" => $usuario, "categoria" => $categoria];
        } else {
            return ["ventanilla" => "Credenciales incorrectas"];
        }
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
    public static function obtenerUsuarios()
    {
        $db = Database::getConexion();
        $sql = "SELECT ventanilla FROM ventanillas";
        $result = $db->query($sql);

        $usuarios = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
            }
        }

        return $usuarios;
    }
}
