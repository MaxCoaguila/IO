<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Modelos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e1e;
            color: #f1f1f1;
            margin: 0;
            margin: 0px;
        }
        header {
            text-align: center;
            padding: 20px;
            background-color: #1f1f1f;
            border-bottom: 2px solid #444;
        }
        p {
            text-align: center;
            color: #ffcc00;
        }
        header h1 {
            margin: 0;
            color: #ffcc00;
        }

        h2 {
            color: #ffcc00;
        }

        .tab-container {
            text-align: center;
            margin-top: 20px;
        }

        .tab {
            display: inline-block;
            padding: 15px 30px;
            font-size: 18px;
            margin: 5px;
            cursor: pointer;
            background-color: #333;
            color: #f1f1f1;
            border: 1px solid #555;
            border-radius: 5px;
        }

        .tab:hover {
            background-color: #444;
        }

        .tab.active {
            background-color: #ffcc00;
            color: #1e1e1e;
        }

        .content-container {
            display: none;
            margin-top: 20px;
            text-align: center;
        }

        .content-container.active {
            display: block;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .button-container button {
            padding: 15px;
            font-size: 18px;
            cursor: pointer;
            background-color: #444;
            color: white;
            border: none;
            border-radius: 5px;
            width: 80%;
            max-width: 400px;
        }

        .button-container button:hover {
            background-color: #ffcc00;
            color: #1e1e1e;
        }

        footer {
            margin-top: 30px;
            text-align: center;
            color: #aaa;
            font-size: 14px;
        }
    </style>
    <script>
        function showTab(tabId) {
            const tabs = document.querySelectorAll('.tab');
            const contents = document.querySelectorAll('.content-container');
            tabs.forEach(tab => tab.classList.remove('active'));
            contents.forEach(content => content.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
            document.querySelector(`[data-tab="${tabId}"]`).classList.add('active');
        }
    </script>
</head>

<header>
        <h1>Sistema de Modelos</h1>
</header>

<body>

    
    <p>Seleccione una categoría para explorar los modelos:</p>
    <div class="tab-container">
        <div class="tab active" data-tab="tab-colas" onclick="showTab('tab-colas')">Variación de Teoría de Colas</div>
        <div class="tab" data-tab="tab-nolineal" onclick="showTab('tab-nolineal')">Programación No Lineal</div>
        <div class="tab" data-tab="tab-dinamica" onclick="showTab('tab-dinamica')">Programación Dinámica</div>
    </div>

    <div id="tab-colas" class="content-container active">
        <h2>Variación de Teoría de Colas</h2>
        <div class="button-container">
            <button onclick="window.location.href='MM1_B.php';">Modelo M/M/1</button>
            <button onclick="window.location.href='MMC.php';">Modelo M/M/C</button>
            <button onclick="window.location.href='TLP.php';">Teorema de Little y Nacimiento y Muerte</button>
            <button onclick="window.location.href='MG1.php';">Modelo M/G/1</button>
            <button onclick="window.location.href='MGCO.php';">Modelo M/G/C/0</button>
            <button onclick="window.location.href='MMCN.php';">Modelo M/G/C/N</button>
        </div>
    </div>

    <div id="tab-nolineal" class="content-container">
        <h2>Programación No Lineal</h2>
        <div class="button-container">
            <button onclick="window.location.href='Programacion_Cuadratica.html';">Programación Cuadrática</button>
            <button onclick="window.location.href='optimizacionSinRestricciones.html';">Optimizacion sin Restricciones</button>
            <button onclick="window.location.href='geometrica.html';">Programacion Geometrica</button>
            <!-- Añade más botones aquí -->
        </div>
    </div>

    <div id="tab-dinamica" class="content-container">
        <h2>Programación Dinámica</h2>
        <div class="button-container">
            <!-- Añade botones para la programación dinámica aquí -->
            <button onclick="window.location.href='holguraRechazos.html';">Determinacion de Holgura por Rechazos</button>
            <button onclick="window.location.href='problema_de_brigadas.php';">Distribucion de Brigadas Medicas entre Paises</button>
        </div>
    </div>

    <footer>
        &copy; 2024 Sistema de Modelos - Todos los derechos reservados.
    </footer>
</body>
</html>
