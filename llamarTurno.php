<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Texto a voz con IA</title>
</head>
<body>
  <h1>Ejemplo de voz en la web</h1>
  <p id="frase">Hola, este es un ejemplo con voz generada por el navegador.</p>
  
  <button onclick="hablar()">🔊 Reproducir voz</button>

  <script>
    function hablar() {
      // Tomamos el texto de la página
      let texto = document.getElementById("frase").innerText;

      // Creamos el objeto de voz
      let voz = new SpeechSynthesisUtterance(texto);
      voz.lang = "es-ES"; // idioma
      voz.rate = 1;       // velocidad (1 es normal)
      voz.pitch = 1;      // tono

      // Reproducir
      window.speechSynthesis.speak(voz);
    }
  </script>
</body>
</html>