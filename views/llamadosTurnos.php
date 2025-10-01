<?php
session_start();
if (!isset($_SESSION['ventanilla'])) {
    // 🚫 No tiene sesión -> lo mandamos al login
    header("Location: ../index.php");
    exit;
}
?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qz-tray/2.1.0/qz-tray.js"></script>
</head>

<body class="bg-blue-50 flex items-center justify-center h-screen">
    <br>

    <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md text-center border border-blue-200">
        <h1 class="text-3xl font-bold text-blue-600 mb-4">
        </h1>
        <p class="text-gray-600 mb-6">
            Has iniciado sesión correctamente en el sistema de turnos. <?php echo $_SESSION['ventanilla']; ?>
        </p>
        <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md text-center border border-blue-200">
            <h1 class="text-3x1">llamar turno</h1>
            <form action="#" method="post" id="llamarTurno" class="space-y-5" novalidate>
                <input type="hidden" id="ventanilla" name="ventanilla" value="<?php echo $_SESSION['ventanilla'];?>">
                <button type="submit" class="submit w-50 rounded-xl bg-blue-600 text-white font-medium py-2.5 shadow hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 transition">llamar Turno</button>
                
            </form>
        </div>
        <div id='respuesta'></div>
    </div>
    <script src="../public/app.js"></script>
</body>

</html>