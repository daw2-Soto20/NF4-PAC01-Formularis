<?php
    $inicioHTML.=<<<html
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Formulario</title>
    </head>
    <body>
html;

echo $inicioHTML;

$form.=<<<formulario
<div style="text-align:center;margin:auto;">
    <h3>Calculadora</h3>
    <form action="UF1-NF4-PAC01-result_SotoOscar.php" method="post">
        <table style="margin:auto">
            <tr>
                <td>number1</td>
                <td><input type="number" name="num1"></td>
            </tr>
            <tr>
                <td/>
                <td> + </td>
            </tr>
            <tr>
                <td>number2</td>
                <td><input type="number" name="num2"></td>
            </tr>
            <tr>
                <td/>
                <td> + </td>
            </tr>
            <tr>
                <td>number3</td>
                <td><input type="number" name="num3"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;">
                <br/>
                <input type="submit" name="submit" value="calcular"></td>
            </tr>
        </table>
    </form>
</div>
formulario;

echo $form;

    $finHTML.=<<<finHTML
        </body>
    </html>
finHTML;
echo $finHTML;
?>