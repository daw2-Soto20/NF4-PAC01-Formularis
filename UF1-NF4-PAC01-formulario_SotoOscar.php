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
        <h3>Formulario Input</h3>
        <form action="UF1-NF4-PAC01-seleccion_SotoOscar.php" method="post">
            <table style="margin:auto">
                <tr>
                    <td>Campo1</td>
                    <td><input type="text" name="campo1"></td>
                </tr>
                <tr>
                    <td>Campo2</td>
                    <td><input type="text" name="campo2"></td>
                </tr>
                <tr>
                    <td>Campo3</td>
                    <td><input type="text" name="campo3"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center;">
                    <br/>
                    <input type="submit" name="submit" value="enviar"></td>
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