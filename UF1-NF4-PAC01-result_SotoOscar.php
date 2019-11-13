<?php
    $inicioHTML.=<<<html
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Resultado Suma</title>
    </head>
    <body>
html;
echo $inicioHTML;

    $num1=$_POST['num1'];
    $num2=$_POST['num2'];
    $num3=$_POST['num3'];

    $resultado=$num1+$num2+$num3;


    $finHTML.=<<<FINAL
            <p style="text-align:center;font-weight:bold;font-size:x-large;">$num1 + $num2 + $num3 = $resultado</p>
        </body>
    </html>
FINAL;

echo $finHTML;
?>