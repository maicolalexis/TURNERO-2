<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administración</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- 🔹 Encabezado -->
  <header class="bg-blue-700 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <h1 class="text-2xl font-bold">🏥 Sistema de Turnos - Admin</h1>
      <nav class="space-x-4">
        <a href="#" class="hover:underline">Inicio</a>
        <a href="#" class="hover:underline">Turnos</a>
        <a href="#" class="hover:underline">Usuarios</a>
        <a href="logout.php" class="bg-red-500 px-3 py-1 rounded-md hover:bg-red-600">Cerrar Sesión</a>
      </nav>
    </div>
  </header>

  <!-- 🔹 Contenido principal -->
  <main class="flex-grow max-w-7xl mx-auto p-6">
    <h2 class="text-xl font-semibold mb-4">Bienvenido, Administrador</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Tarjeta 1 -->
      <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
        <h3 class="text-lg font-bold mb-2">📋 Turnos pendientes</h3>
        <p class="text-gray-600">Consulta y administra los turnos en espera.</p>
        <a href="turnospendientes.php" class="mt-3 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ver más</a>
      </div>

      <!-- Tarjeta 2 -->
      <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
        <h3 class="text-lg font-bold mb-2">👥 Usuarios</h3>
        <p class="text-gray-600">Gestiona los usuarios registrados en el sistema.</p>
        <a href="usuarios.php" class="mt-3 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Administrar</a>
      </div>

      <!-- Tarjeta 3 -->
      <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
        <h3 class="text-lg font-bold mb-2">⚙️ Configuración</h3>
        <p class="text-gray-600">Personaliza parámetros del sistema.</p>
        <a href="configuracion.php" class="mt-3 inline-block bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Abrir</a>
      </div>
    </div>
  </main>

  <!-- 🔹 Pie de página -->
  <footer class="bg-blue-700 text-white text-center py-4">
    <p>© <?php echo date("Y"); ?> Sistema de Turnos - Todos los derechos reservados</p>
  </footer>

</body>
</html>
