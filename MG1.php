<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo de Cola M/G/1</title>
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
    <h1>Modelo de Cola M/G/1</h1>
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

        <label for="variance">Varianza del tiempo de servicio (S²):</label>
        <input type="number" step="0.01" name="variance" id="variance" required>
        <br><br>

        <button type="submit">Calcular</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recibir los valores de entrada
        $lambda = (float) $_POST["lambda"];
        $mu = (float) $_POST["mu"];
        $variance = (float) $_POST["variance"];

        // Validación de entrada
        if ($lambda <= 0 || $mu <= 0 || $variance < 0) {
            echo "<div class='results'><strong>Error:</strong> Los valores deben ser positivos y mayores que cero.</div>";
            exit;
        }

        // Verificar que el sistema sea estable (ρ < 1)
        $rho = $lambda / $mu;
        if ($rho >= 1) {
            echo "<div class='results'><strong>Error:</strong> El sistema no es estable porque la utilización ρ debe ser menor que 1.</div>";
        } else {
            // Cálculos del modelo M/G/1
            $Lq = ($lambda**2 * $variance) / (2 * (1 - $rho)); // Número promedio en la cola
            $Wq = $Lq / $lambda;                              // Tiempo promedio en la cola
            $W = $Wq + (1 / $mu);                             // Tiempo promedio en el sistema
            $L = $lambda * $W;                                // Número promedio en el sistema

            // Mostrar resultados
            echo "<div class='results'>";
            echo "<h3>Resultados para el modelo M/G/1:</h3>";
            echo "<p>Factor de utilización (ρ): " . round($rho, 2) . "</p>";
            echo "<p>Tiempo promedio en el sistema (W): " . round($W, 2) . " unidades de tiempo</p>";
            echo "<p>Número promedio de clientes en el sistema (L): " . round($L, 2) . "</p>";
            echo "<p>Número promedio de clientes en la cola (Lq): " . round($Lq, 2) . "</p>";
            echo "<p>Tiempo promedio de espera en la cola (Wq): " . round($Wq, 2) . " unidades de tiempo</p>";
            echo "</div>";
        }
    }
    ?>

</div>

<footer>
    <button onclick="window.location.href='index.php';">Volver al Inicio</button>
</footer>

</body>
</html>
