<?php
require_once '../models/Usuario.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['nombreusuario']) && isset($data['claveacceso'])) {
        $nombreusuario = $data['nombreusuario'];
        $claveacceso = $data['claveacceso'];

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->login(['nombreusuario' => $nombreusuario]);

        if (!empty($usuario)) {
            // Verificar la contraseña
            if (password_verify($claveacceso, $usuario[0]['claveacceso'])) {
                // Devolver los datos del usuario si la autenticación es exitosa
                echo json_encode([
                    "success" => true,
                    "message" => "Inicio de sesión exitoso",
                    "data" => $usuario[0]
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Contraseña incorrecta"
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Usuario no encontrado"
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Faltan datos: nombreusuario y claveacceso"
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Método no permitido"
    ]);
}
?>
