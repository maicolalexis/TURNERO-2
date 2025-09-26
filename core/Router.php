<?php
class Router {
    public function run() {
        $controller = $_GET['c'] ?? 'usuario'; // controlador por defecto
        $action     = $_GET['a'] ?? 'login';   // acción por defecto

        $controllerName = ucfirst($controller) . "Controller";
        $controllerFile = "Controllers/$controllerName.php";

        // 1. Validar archivo
        if (!file_exists($controllerFile)) {
            die("❌ Controlador '$controllerName' no encontrado");
        }

        require_once $controllerFile;

        // 2. Validar clase
        if (!class_exists($controllerName)) {
            die("❌ Clase '$controllerName' no existe en $controllerFile");
        }

        $obj = new $controllerName();

        // 3. Validar método
        if (!method_exists($obj, $action)) {
            die("❌ Acción '$action' no existe en el controlador '$controllerName'");
        }

        // 4. Ejecutar acción
        $obj->$action();
    }
}
