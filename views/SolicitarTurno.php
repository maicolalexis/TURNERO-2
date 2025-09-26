<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qz-tray/2.1.0/qz-tray.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
<body class="bg-blue-50 flex items-center justify-center h-screen">
    <br>

    <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md text-center border border-blue-200">
        <h1 class="text-3xl font-bold text-blue-600 mb-4">
        </h1>
        <p class="text-gray-600 mb-6">
            Has iniciado sesión correctamente en el sistema de turnos.
        </p>
        <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md text-center border border-blue-200">
            <h1 class="text-3x1">llamar turno</h1>
            <button type="submit" id="btnTurnoCitaMedica" class="submit w-50 rounded-xl bg-blue-600 text-white font-medium py-2.5 shadow hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 transition">cita medica</button>
            <br><br>
            <button type="submit" id="btnTurnoCitaMedicaP" class="submit w-50 rounded-xl bg-blue-600 text-white font-medium py-2.5 shadow hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 transition">cita medica preferencial</button>
            <br><br>
            <button type="submit" id="btnTurnoFacturacion" class="submit w-50 rounded-xl bg-blue-600 text-white font-medium py-2.5 shadow hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 transition">facturacion</button>
            <br><br>
            <button type="submit" id="btnTurnoFacturacionP" class="submit w-50 rounded-xl bg-blue-600 text-white font-medium py-2.5 shadow hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 transition">facturacion preferencial</button>
            <div id='respuesta'></div>
        </div>
    </div>
    <script src="../public/app.js"></script>  
</body>
</html>
