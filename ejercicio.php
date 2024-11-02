<?php
    // si es positivo o negativo
    $numero1 = 10;
    if($numero1 > 0)
    {
        echo "el numero es positivo";
    }else{
        echo "el numero es negativo";
    }

    //velocidad del viento
    $viento = 80;
    if($viento < 20)
    {
        echo "la velocidad del viento es baja";
    }else if($viento >= 20){
        echo "la velocidad del viento es alta";
    }

    //comparacionde cadena

    $cadena1 = "rojo";
    if($cadena1 == "rojo" ? "el color es rojo" : "el color no es rojo")
    {
        echo "el color es rojo";
    }

    //validar la edad para una pelicula
    echo($edad >= 18 ?"pude ver la pelicula":
        "no pude ver la pelicula")  
    
        	
?>