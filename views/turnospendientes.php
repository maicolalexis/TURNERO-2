<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Turnos Pendientes</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body id="turnosPage" class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Encabezado -->
  <header class="bg-blue-600 text-white py-4 shadow-md">
    <div class="container mx-auto px-6 flex justify-between items-center">
      <h1 class="text-2xl font-bold">Panel de Administración - Turnos</h1>
      <nav>
        <ul class="flex gap-4">
          <li><a href="index.php" class="hover:underline">Inicio</a></li>
          <li><a href="turnos.php" class="hover:underline">Turnos</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Contenido -->
  <main class="flex-1 container mx-auto px-6 py-8">

    <?php
    // Cargar archivo JSON con turnos pendientes
    $file = __DIR__ . "/../data/turnos.json";
    $turnos = [];
    if (file_exists($file)) {
      $turnos = json_decode(file_get_contents($file), true);
      if (!is_array($turnos)) {
        $turnos = [];
      }
    }

    // Contadores por categoría
    $contadores = [];
    foreach ($turnos as $t) {
      $cat = $t["categoria"] ?? "sin categoría";
      if (!isset($contadores[$cat])) {
        $contadores[$cat] = 0;
      }
      $contadores[$cat]++;
    }
    ?>

    <!-- Contadores -->
    <h2 class="text-xl font-bold mb-4">Resumen de turnos por categoría</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
      <?php foreach ($contadores as $categoria => $cantidad): ?>
        <div class="bg-white p-4 rounded-lg shadow text-center">
          <h3 class="text-lg font-semibold capitalize"><?php echo htmlspecialchars($categoria); ?></h3>
          <p class="text-2xl font-bold text-blue-600"><?php echo $cantidad; ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Tabla de turnos -->
    <h2 class="text-xl font-bold mb-4">Turnos pendientes</h2>
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
      <table class="min-w-full border border-gray-200">
        <thead class="bg-gray-200">
          <tr>
            <th class="py-3 px-4 text-left">Categoría</th>
            <th class="py-3 px-4 text-left">Turno</th>
            <th class="py-3 px-4 text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($turnos as $t): ?>
            <tr class="border-b">
              <td class="py-3 px-4"><?php echo htmlspecialchars($t["categoria"]); ?></td>
              <td class="py-3 px-4"><?php echo htmlspecialchars($t["turno"]); ?></td>
              <td class="py-3 px-4 text-center">
                <!-- Seleccionar usuario -->
                <select id="usuarioSelect" class="usuarioSelect border rounded px-2 py-1">
                  <option value="">Seleccione usuario</option>
                  <!-- JS llenará los usuarios desde MySQL -->
                </select>

                <!-- Botón llamar -->
                <button
                  data-turno="<?php echo $t["turno"]; ?>"
                  class="btnLlamar bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 mt-2">
                  Llamar
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <!-- Modal alerta -->
    <div id="alertaModal" class="hidden fixed inset-0 flex items-center justify-center bg-black/50 z-50">
      <div class="bg-white rounded-lg shadow-lg p-6 w-80 text-center">
        <h2 id="alertaTitulo" class="text-lg font-bold mb-2">Mensaje</h2>
        <p id="alertaMensaje" class="text-gray-700 mb-4"></p>
        <button id="cerrarAlerta" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Aceptar
        </button>
      </div>
    </div>


    <!-- Respuesta -->
    <div id="respuesta" class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-lg text-center"></div>
  </main>

  <script src="../public/app.js"></script>
</body>

</html>