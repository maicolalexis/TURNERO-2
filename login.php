<!doctype html>

<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Iniciar sesión</title>
    <!-- Tailwind CSS v4 CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  </head>
  <body class="min-h-svh bg-gradient-to-br from-slate-50 to-slate-200 flex items-center justify-center p-6">
    <main class="w-full max-w-md">
      <!-- Card -->
      <div class="bg-white/90 backdrop-blur rounded-2xl shadow-xl border border-slate-100">
        <div class="p-8">
          <!-- Logo / encabezado -->
          <div class="flex flex-col items-center gap-3 mb-8">
            <div class="size-45 rounded-2xl bg-blue-600/10 flex items-center justify-center">
              <span class="text-xl text-center font-black text-blue-700">Integra Soluciones</span>
            </div>
            <div class="text-center">
              <h1 class="text-2xl font-semibold text-slate-800">Iniciar sesión</h1>
              <p class="text-sm text-slate-500 mt-1">Ingresa tus credenciales para continuar</p>
              <div class="text-2x1 text-red-danger" id="respuesta"></div>
            </div>
          </div>

          <!-- Formulario -->
          <form action="#" method="post" id="formLogin" class="space-y-5" novalidate>
            <div class="space-y-2">
              <label for="usuario" class="block text-sm font-medium text-slate-700">Correo electrónico</label>
              <input id="usuario" name="usuario" type="email" required autocomplete="username" placeholder="usuario@correo.com" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-slate-900 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-400" />
            </div>

            <div class="space-y-2">
              <div class="flex items-center justify-between">
                <label for="clave" class="block text-sm font-medium text-slate-700">Contraseña</label>
              </div>
              <input id="clave" name="clave" type="password" required autocomplete="current-password" placeholder="••••••••" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-slate-900 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-400" />
            </div>

            <div class="flex items-center justify-between">
              <label class="inline-flex items-center gap-3 select-none">
                <input type="checkbox" name="remember" class="size-4 rounded border-slate-300 text-blue-600 focus:ring-blue-200" />
                <span class="text-sm text-slate-600">Recordarme</span>
              </label>
            </div>

            <button type="submit" class="submit w-full rounded-xl bg-blue-600 text-white font-medium py-2.5 shadow hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 transition">Entrar</button>
          </form>
          
        </div>

        <!-- Divider -->
        <div class="px-8">
          <div class="relative my-4">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
              <div class="w-full border-t border-slate-200"></div>
            </div>
            <div class="relative flex justify-center">
              <span class="bg-white px-3 text-xs text-slate-500">o</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer pequeño -->
      <p class="mt-6 text-center text-xs text-slate-500">
        © <span id="year"></span> Integra. Todos los derechos reservados.
      </p>
    </main>

    <script>
      // Año dinámico (opcional, sigue siendo un único archivo HTML)
      document.getElementById('year').textContent = new Date().getFullYear();
      
    </script>
    <script src="public/app.js"></script>  
  </body>
</html>

