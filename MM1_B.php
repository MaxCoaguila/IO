<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo de Cola M/M/1</title>
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
    <h1>Modelo de Cola M/M/1</h1>
</header>

<div class="form-container">
    <h2>Calculadora</h2>
    <form method="POST">
        <label for="lambda">Tasa de llegada promedio (λ):</label>
        <input type="number" step="0.01" name="lambda" id="lambda" required>

        <label for="mu">Tasa de servicio promedio (μ):</label>
        <input type="number" step="0.01" name="mu" id="mu" required>

        <button type="submit">Calcular</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $lambda = (float) $_POST["lambda"];
        $mu = (float) $_POST["mu"];

        if ($mu <= $lambda) {
            echo "<div class='results'><strong>Error:</strong> El sistema no es estable porque la tasa de servicio (μ) debe ser mayor que la tasa de llegada (λ).</div>";
        } else {
            $rho = $lambda / $mu;
            $L = $rho / (1 - $rho);
            $Lq = $L - $rho;
            $W = 1 / ($mu - $lambda);
            $Wq = $W - (1 / $mu);

            echo "<div class='results'>";
            echo "<h3>Resultados:</h3>";
            echo "<p>Factor de utilización (ρ): " . round($rho, 2) . "</p>";
            echo "<p>Número promedio en el sistema (L): " . round($L, 2) . "</p>";
            echo "<p>Número promedio en la cola (Lq): " . round($Lq, 2) . "</p>";
            echo "<p>Tiempo promedio en el sistema (W): " . round($W, 2) . "</p>";
            echo "<p>Tiempo promedio en la cola (Wq): " . round($Wq, 2) . "</p>";
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
