<?php
class Database
{
    private $hostname = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'torneofutbol';

    public function conectar()
    {
        try {
            $pdo = new PDO("mysql:host=$this->hostname;dbname=$this->database", $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec("SET NAMES 'utf8'");
            return $pdo;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit();
        }
    }
}
?>
