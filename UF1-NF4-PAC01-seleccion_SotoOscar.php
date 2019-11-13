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

    $campo1=$_POST['campo1'];
    $campo2=$_POST['campo2'];
    $campo3=$_POST['campo3'];

    $form.=<<<formSeleccion
    <div style="text-align:center;margin:auto;">
        <h3>Formulario Seleccion</h3>
            <table style="margin:auto">
                <tr>
                    <td>Seleccion</td>
                    <td>
                        <select name="campos">
                            <option value="1">$campo1</option>
                            <option value="2">$campo2</option>
                            <option value="3">$campo3</option>
                        </select>
                    </td>
                </tr>
            </table>
    </div>
formSeleccion;

echo $form;

    $finHTML.=<<<finHTML
        </body>
    </html>
finHTML;

echo $finHTML;
?>