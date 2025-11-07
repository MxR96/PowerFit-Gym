<?php
session_start();
// Asegúrate de que las rutas a config y includes sean correctas para tu proyecto
require_once __DIR__ . '/../config/conexion.php';
include __DIR__ . '/../includes/header.php';
?>

<h2 class="mb-3">Bienvenido a PowerFit</h2>
<p>Convertite en tu mejor versión. Horarios: Lunes a Sábado de 7:00 a 22:00 hs.</p>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Nuestros planes</h5>
                <p class="card-text">Básico, Pro y Premium. Consultá precios con nuestro chatbot.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Ubicación</h5>
                <p class="card-text">Av. Siempre Viva 742</p>
            </div>
        </div>
    </div>
</div>

<div id="chatbot-container" style="position: fixed; bottom: 20px; right: 20px; z-index: 10000;">
    
    <div id="chat-window" style="
        display: none; 
        background: white; 
        border: 1px solid #ddd; 
        border-radius: 8px; 
        width: 350px; /* Ancho ajustado para mejor lectura */
        max-height: 80vh; /* Permite crecer hasta el 80% de la altura de la pantalla */
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        margin-bottom: 10px;
    ">
        
        <div id="chat-log" style="
            max-height: 70vh; /* El log puede crecer hasta el 70% de la altura de la pantalla */
            overflow-y: auto; /* Permite la barra de desplazamiento si se supera el max-height */
            padding: 10px; 
            border-bottom: 1px solid #eee;
        ">
            <p><b>GymBot:</b> ¡Hola! Pregúntame sobre horarios, precios o planes. 👋</p>
        </div>

        <div style="padding: 10px; display: flex;">
            <input 
                type="text" 
                id="user-input" 
                placeholder="Escribe tu consulta..." 
                style="flex-grow: 1; margin-right: 5px; padding: 5px;"
            >
            <button onclick="sendMessage()">Enviar</button>
        </div>
    </div>
    
    <button id="chat-toggle-button" style="
        padding: 10px 15px; 
        border: none; 
        border-radius: 20px; 
        background-color: #007bff; /* Color principal */
        color: white; 
        cursor: pointer; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    ">
        Abrir Chat
    </button>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

