<?php
require_once __DIR__ . '/../Models/Usuario.php';

class UsuarioController
{
    public function login()
    {
        require "login.php";
    }

    // Método que responderá a AJAX
    public function autenticar()
    {
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
    public function cerrarSesion()
    {
        session_start();
        session_unset();   // limpia las variables
        session_destroy(); // destruye la sesión
        header("Location: index.php"); // vuelve al login
        exit;
    }

    function listarUsuarios()
    {
        $usuarios = Usuario::obtenerUsuarios();  // <-- wstatic call
        if (!empty($usuarios)) {
            echo json_encode([
                "status" => "ok",
                "data" => $usuarios
            ], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                "status" => "error",
                "msg" => "No se encontraron usuarios"
            ]);
        }
    }
    
}

// Verificamos que se llamó con POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "listar") {
    header('Content-Type: application/json; charset=utf-8');
    $controller = new UsuarioController();
    $controller->listarUsuarios();
} else {
}
