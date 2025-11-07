<?php
// CLAVE: INICIAR SESIÓN para verificar la autenticación
session_start();
header('Content-Type: application/json; charset=utf-8');

// --- 1. PROCESAR ENTRADA ---
$input = json_decode(file_get_contents('php://input'), true);
$userInput = trim($input['input'] ?? '');

if (!$userInput) {
    echo json_encode(['plan' => 'No recibí ninguna consulta.']);
    exit;
}

$inputLower = mb_strtolower($userInput, 'UTF-8');
$respuesta = 'No entendí tu consulta. Prueba con "horario" o "precios" 🤔';


// --- 2. LÓGICA DE RESPUESTAS ESTÁTICAS ---
if (strpos($inputLower, 'horario') !== false) {
    $respuesta = 'Abrimos de 7 a 22 hs de lunes a sábado.';
} elseif (strpos($inputLower, 'precio') !== false || strpos($inputLower, 'planes') !== false) {
    $respuesta = 'Tenemos 3 planes: Básico $20.000, Pro $30.000 y Premium $50.000.';
} elseif (strpos($inputLower, 'ubicacion') !== false) {
    $respuesta = 'Estamos en Av. Siempre Viva 742.';
} 


// --- 3. LÓGICA AVANZADA: GENERAR RUTINA CON GEMINI (Solo Socios Logueados) ---
if (strpos($inputLower, 'generar rutina') !== false || strpos($inputLower, 'entrenamiento') !== false) {
    
    // 🚨 VERIFICACIÓN CORREGIDA: Chequea si la variable de sesión 'usuario' existe.
    if (!isset($_SESSION['usuario'])) {
        $respuesta = '🔒 Debes **iniciar sesión** para que pueda generarte un plan de entrenamiento personalizado.';
    } else {
        // USUARIO LOGUEADO: LLAMADA A LA API DE GEMINI
        
        $api_key = 'AIzaSyDM70kRX5MxFCuKRaeycakBNAiVAY7MwAQ'; 
        
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $api_key;
        
        // Prompt (Instrucción para la IA)
        $context_prompt = "Eres un entrenador personal. Genera un plan de entrenamiento (ej. 4 días) basado en la siguiente solicitud: " . $userInput . ". Usa un formato de lista con emojis y encabezados Markdown para claridad.";

        $payload = json_encode([
            'contents' => [
                ['role' => 'user', 'parts' => [['text' => $context_prompt]]]
            ]
        ]);

        // Ejecución de la solicitud cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 200) {
            $gemini_response = json_decode($response, true);
            $respuesta = $gemini_response['candidates'][0]['content']['parts'][0]['text'] ?? '⚠️ La IA no pudo generar el plan. Intenta una solicitud más específica.';
        } else {
             $respuesta = '❌ Error al conectar con el servicio de entrenamiento (Código: ' . $http_code . '). Verifica tu conexión a Internet y la clave API.';
        }
    }
}

echo json_encode(['plan' => $respuesta]);