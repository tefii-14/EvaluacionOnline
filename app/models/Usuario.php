<?php

require_once "Conexion.php";

/**
 * Contiene toda la lógica (CRUD) de acceso a datos
 */
class Usuario extends Conexion{

  //Objeto a nivel de clase, que almacena la conexión
  private $pdo;

  /**
   * Al momento de instanciar esta clase, el objeto "pdo" recibe la conexión
   */
  public function __CONSTRUCT() { $this->pdo = parent::getConexion(); }

  /**
   * Validará el acceso en 2 pasos (primero usuario, segundo contraseña)
   * @param array $params Arreglo que contiene el nombre de usuario
   * @return array Retornará una colección
   */
  public function login($params = []): array {
    try {
        // Preparar la consulta llamando al procedimiento almacenado
        $cmd = $this->pdo->prepare("CALL spu_usuarios_login(:nombreusuario)");

        // Asignar el valor del parámetro
        $cmd->bindValue(":nombreusuario", $params['nombreusuario'], PDO::PARAM_STR);

        // Ejecutar el procedimiento almacenado
        $cmd->execute();

        // Obtener los datos del usuario como un array asociativo
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Error login: " . $e->getMessage());
        return [];
    }
  }


  public function add(){}
  public function update(){}
  public function delete(){}

} //Fin clase