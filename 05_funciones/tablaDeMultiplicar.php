<?php
    function calcularTabla($numero){
        $count = 1;
        $resultado="";
        if($numero !=""){
            for($i = 1; $i <= 10; $i++){
                $resultado=($numero*$count);           
                echo "<tr>";
                echo "<td>$numero</td>";
                echo "<td>x</td>";
                echo "<td>$count</td>";
                echo "<td>=</td>";
                echo "<td>$resultado</td>";
                echo "</tr>";
                $count++;
            }
        }else{
            echo "<p>Faltan datos</p>";
        }
        
    }
?>