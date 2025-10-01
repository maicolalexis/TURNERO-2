<?php
class Database {
    public static function getConexion() {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db   = "hospital";
        return new mysqli($host, $user, $pass, $db);
    }
    
}
