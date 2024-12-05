<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esquema de Nacimiento y Muerte - M/M/1 con Capacidad Máxima</title>
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
    <h1>Esquema de Nacimiento y Muerte - Modelo M/M/1 con Capacidad Máxima</h1>
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

        <label for="capacity">Capacidad máxima del sistema (N):</label>
        <input type="number" name="capacity" id="capacity" required min="1">
        <br><br>

        <button type="submit">Calcular</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recibir valores de entrada
        $lambda = (float) $_POST["lambda"];
        $mu = (float) $_POST["mu"];
        $capacity = (int) $_POST["capacity"];

        // Validar entradas
        if ($lambda <= 0 || $mu <= 0 || $capacity < 1) {
            echo "<div class='results'><strong>Error:</strong> λ, μ deben ser mayores a 0 y la capacidad debe ser al menos 1.</div>";
            exit;
        }

        // Calcular factor de utilización
        $rho = $lambda / $mu;

        // Calcular P0 considerando límite de capacidad
        $p0_sum = 0;
        for ($n = 0; $n <= $capacity; $n++) {
            $p0_sum += pow($rho, $n);
        }
        $p0 = 1 / $p0_sum;

        // Calcular probabilidades de los estados
        $probabilidades = [];
        for ($n = 0; $n <= $capacity; $n++) {
            $probabilidades[$n] = $p0 * pow($rho, $n);
        }

        // Calcular L (longitud promedio de clientes en el sistema)
        $L = 0;
        for ($n = 1; $n <= $capacity; $n++) {
            $L += ($n) * $probabilidades[$n];
        }

        // Calcular Lq (longitud promedio de la cola)
        $Lq = 0;
        for ($n = 2; $n <= $capacity; $n++) {
            $Lq += ($n - 1) * $probabilidades[$n];
        }

        // Calcular Wq (tiempo promedio en la cola)
        $Wq = $Lq / $lambda;

        // Mostrar resultados
        echo "<div class='results'>";
        echo "<h3>Resultados para el esquema de Nacimiento y Muerte - M/M/1:</h3>";
        echo "<p>Factor de utilización (ρ): " . round($rho, 3) . "</p>";
        echo "<p>Probabilidad de que el sistema esté vacío (P₀): " . round($p0, 4) . "</p>";
        echo "<p>Longitud promedio clientes en el sistema (L): " . round($L, 2) . " clientes</p>";
        echo "<p>Longitud promedio clientes en la cola (Lq): " . round($Lq, 2) . " clientes</p>";
        echo "<p>Tiempo promedio de espera en la cola (Wq): " . round($Wq, 2) . " unidades de tiempo</p>";

        // Mostrar probabilidades de los estados
        echo "<h4>Probabilidades de los estados:</h4>";
        foreach ($probabilidades as $n => $pn) {
            echo "<p>Probabilidad de que haya $n clientes en el sistema (P$n): " . round($pn, 4) . "</p>";
        }
        echo "</div>";
    }
    ?>
</div>

<footer>
    <button onclick="window.location.href='index.php';">Volver al Inicio</button>
</footer>

</body>
</html>
