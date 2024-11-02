<?php
    $arreglo = array("Juan", 20, 1.80, false);
    $arreglo2 = ["Juan", 20, 1.80, true];

    //clave => valor
    $arreglo3 = array(
        "nombre" => "Juan",
        "edad" => 20,
        "altura" => 1.80,
        "casado" => true,
    );

    //adicinal campo de imail
    $arreglo3["email"] = "jormancontreras@gamil.com";
    $arreglo3["edad"] = "28";
    // modificar valores
    $arreglo3["celular"] = "12249848";
    
    //eliminar el ultimo elemanto del array
    //array_pop($arreglo3);

    echo"<pre>";
    //var_dump($arreglo2);
    //var_dump($arreglo2[1]);

    ///var_dump($arreglo3["nombre"]);
    //var_dump($arreglo3["cedula"]);
    
    var_dump($arreglo3);

    //buscar un valor en un array devuelve un true o false
    var_dump(in_array(28, $arreglo3));

    echo"</pre>";
?>