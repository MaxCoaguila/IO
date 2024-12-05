<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo de Cola M/M/c</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #121212;
            color: #eaeaea;
            margin: 0;
            padding: 0;
        }
        header {
            text-align: center;
            padding: 20px;
            background-color: #1f1f1f;
            border-bottom: 2px solid #444;
        }
        header h1 {
            margin: 0;
            color: #ffcc00;
        }
        .form-container {
            max-width: 500px;
            margin: 40px auto;
            background-color: #1f1f1f;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .form-container h2 {
            color: #ffcc00;
            text-align: center;
        }
        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .form-container input {
            width: 96%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #444;
            border-radius: 4px;
            background-color: #2a2a2a;
            color: #eaeaea;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #4caf50;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
        .results {
            margin-top: 20px;
            padding: 15px;
            background-color: #2a2a2a;
            border: 1px solid #444;
            border-radius: 4px;
        }
        .results h3 {
            color: #ffcc00;
        }
        .results p {
            margin: 5px 0;
        }
        footer {
            text-align: center;
            margin-top: 20px;
        }
        footer button {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        footer button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<header>
    <h1>Modelo de Cola M/M/c</h1>
</header>

<div class="form-container">
    <h2>Calculadora</h2>
    <form method="POST">
        <label for="lambda">Tasa de llegada promedio (λ):</label>
        <input type="number" step="0.01" name="lambda" id="lambda" required>
        <br><br>
        
        <label for="mu">Tasa de servicio promedio (μ):</label>
        <input type="number" step="0.01" name="mu" id="mu" required>
        <br><br>

        <label for="c">Número de servidores (c):</label>
        <input type="number" name="c" id="c" required min="1">
        <br><br>

        <button type="submit">Calcular</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recibir valores de lambda, mu y c
        $lambda = (float) $_POST["lambda"];
        $mu = (float) $_POST["mu"];
        $c = (int) $_POST["c"];

        // Validación para asegurar la estabilidad del sistema
        $rho = $lambda / ($c * $mu);
        if ($rho >= 1) {
            echo "<div class='results'><strong>Error:</strong> El sistema no es estable porque la utilización ρ debe ser menor que 1.</div>";
        } else {
            // Cálculo de P0 (probabilidad de que el sistema esté vacío)
            $sumatoria = 0;
            for ($n = 0; $n < $c; $n++) {
                $sumatoria += pow($c * $rho, $n) / factorial($n);
            }
            $p0 = 1 / ($sumatoria + (pow($c * $rho, $c) / (factorial($c) * (1 - $rho))));

            // Cálculo de Pc (probabilidad de esperar en la cola)
            $pc = (pow($c * $rho, $c) / (factorial($c) * (1 - $rho))) * $p0;

            // Cálculo de Lq (número promedio de clientes en la cola)
            $Lq = $pc * ($rho / (1 - $rho));

            // Cálculo de L (número promedio de clientes en el sistema)
            $L = $Lq + ($lambda / $mu);

            // Cálculo de Wq (tiempo promedio en la cola)
            $Wq = $Lq / $lambda;

            // Cálculo de W (tiempo promedio en el sistema)
            $W = $Wq + (1 / $mu);

            // Mostrar resultados
            echo "<div class='results'>";
            echo "<h3>Resultados para el modelo M/M/c:</h3>";
            echo "<p>Factor de utilización por servidor (ρ): " . round($rho, 2) . "</p>";
            echo "<p>Probabilidad de que todos los servidores estén vacios (P0): " . round($p0, 4) . "</p>";
            echo "<p>Probabilidad de que todos los servidores estén ocupados (Pc): " . round($pc, 4) . "</p>";
            echo "<p>Número promedio de clientes en la cola (Lq): " . round($Lq, 2) . "</p>";
            echo "<p>Número promedio de clientes en el sistema (L): " . round($L, 2) . "</p>";
            echo "<p>Tiempo promedio en la cola (Wq): " . round($Wq, 2) . " unidades de tiempo</p>";
            echo "<p>Tiempo promedio en el sistema (W): " . round($W, 2) . " unidades de tiempo</p>";
            echo "</div>";
        }
    }

    // Función para calcular el factorial
    function factorial($num) {
        $factorial = 1;
        for ($i = 1; $i <= $num; $i++) {
            $factorial *= $i;
        }
        return $factorial;
    }
    ?>
</div>

<footer>
    <button onclick="window.location.href='index.php';">Volver al Inicio</button>
</footer>

</body>
</html>
