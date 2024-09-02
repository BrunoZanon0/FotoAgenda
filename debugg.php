<?php 

function dd(...$vars) {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DD</title>
        <style>
            body { font-family: Arial, sans-serif; padding: 20px;background-color: #000; font-size:.9em}
            .dd-container { border: 1px solid green; border-radius: 5px; padding: 10px; background-color: black; line-height: 1;}
            .dd-title { font-weight: bold;  color:white }
            .dd-content { white-space: pre-wrap; color:green; font-weight: bold; }
            .dd-error { color: red; }
        </style>
    </head>
    <body>
        <div class="dd-container">
            <div class="dd-title">Resultados do DD</div>';
    
            foreach ($vars as $var) {
                echo '<div class="dd-content">';
                echo '<pre>';
                print_r($var);
                echo '</pre>';
                echo '</div>';
            }
    
    echo '</div>
    </body>
    </html>';
    
    die();
}
?>