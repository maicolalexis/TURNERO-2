<?php
require "Models/Usuario.php";

class UsuarioController {
    public function login() {
        require "login.php";
    }

    // Método que responderá a AJAX
   public function autenticar() {
    $usuario = $_POST['usuario'] ?? '';
    $clave   = $_POST['clave'] ?? '';

    $model = new Usuario();
    $user = $model->verificar($usuario, $clave);
    if ($user['ventanilla'] !=  "Credenciales incorrectas") {
        // ✅ Iniciamos sesión
        session_start();
        $_SESSION['ventanilla'] = $user['ventanilla']; // o el ID
        $_SESSION['categoria'] = $user['categoria'];
        echo json_encode([
            "status" => "ok",
            "msg" => "Bienvenido " . $user['ventanilla']
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "msg" => "Usuario o contraseña incorrectos"
        ]);
    }
}
public function cerrarSesion() {
    session_start();
    session_unset();   // limpia las variables
    session_destroy(); // destruye la sesión
    header("Location: index.php"); // vuelve al login
    exit;
}
}
    