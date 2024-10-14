<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salario Impuestos</title>
</head>
<body>
    <form action="" method="post">
    <label for="sueldo" >Sueldo</label>
    <input type="text" name="sueldo" id="sueldo">
    <input type="submit" value="Calcular">
    </form>

    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $sueldo = $_POST["sueldo"];
            $resultado = 0;

            if($sueldo <= 12450){
                $iva19 = $sueldo * 0.19;
                $resultado = $iva19;
            }
            elseif($sueldo <= 20199 ){
                $iva19 = 12450 * 0.19;
                $iva24 = (($sueldo - 12450) * 0.24 );
                $resultado = $iva24 + $iva19;
            }
            elseif($sueldo <= 35199 ){
                $iva19 = 12450 * 0.19;
                $iva24 = ((20199 - 12450) * 0.24 );
                $iva30 = (($sueldo -20199) *0.30) ;
                $resultado = $iva30+$iva24+$iva19;
            }
            elseif($sueldo <=  59999){
                $iva19 = 12450 * 0.19;
                $iva24 = ((20199 - 12450) * 0.24 );
                $iva30 = ((35199 -20199) *0.30) ;
                $iva37 = (($sueldo-35199) *0.37) ;
                $resultado = $iva37+ $iva30+$iva24+ $iva19;
            }
            elseif($sueldo <=  299999){
                $iva19 = 12450* 0.19;
                $iva24 = ((20199 - 12450) * 0.24 );
                $iva30 = ((35199 -20199) *0.30) ;
                $iva37 = ((59999-35199) *0.37) ;
                $iva45 = (($sueldo-59999) *0.45 );
                $resultado = $iva45+$iva37+$iva30+$iva24+$iva19;
            }
            else{
                $iva19 = $sueldo * 0.19;
                $iva24 = ((12450 - 12450) * 0.24 );
                $iva30 = ((20199 -20199) *0.30) ;
                $iva37 = ((35199-35199) *0.37) ;
                $iva45 = ((2999999-59999) *0.45 );
                $iva47 = (($sueldo-299999)*0.47);
                $resultado = $iva47+$iva45+$iva37+$iva30+$iva24+$iva19;
            }
            $resultado = $sueldo -$resultado;
            echo "<p>Cobras $sueldo y hacienda después de robarte que queda: $resultado</p>";
        }
        
    ?>
</body>
</html>