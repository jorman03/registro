<?php

function limpiar_dato($dato){
    return htmlspecialchars(trim($dato));
}

function verificar_rol($rol){
    return isset($_SESSION['user_role'])&& $_SESSION['USER_ROLE'] === $rol;
}
?>