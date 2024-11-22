<?php

//Utilice siempre contraseñas seguras
$clave1 = "admin123";
$clave2 = "deya123";

var_dump(password_hash($clave1, PASSWORD_BCRYPT));
var_dump(password_hash($clave2, PASSWORD_BCRYPT));