<?php
    $nota = 3.5;	
    echo "primera nota"."<br>";
    if($nota >= 2.9){
        echo "ganste la asignatura";
    }else{
        echo "perdiste la asignatura";
    }

    echo "<br>"."segunda nota"."<br>";
    echo ($nota >= 2.9 ? "ganaste la asignatura" 
    : "perdiste la asignatura")
?>