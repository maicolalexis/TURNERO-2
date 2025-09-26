<?php
require_once "core/Database.php";

class Usuario {
    public function verificar($usuario, $clave) {
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
}
