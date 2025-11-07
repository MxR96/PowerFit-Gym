// chatbot.js

// Funciones de Lógica (DEBEN ser globales para el HTML, aunque ya no las usemos directamente)

async function sendMessage() {
    const inputElement = document.getElementById("user-input");
    const log = document.getElementById("chat-log");
    const userInput = inputElement.value.trim();
    if (!userInput) return;

    log.innerHTML += `<p><b>Tú:</b> ${escapeHtml(userInput)}</p>`;
    
    try {
        const res = await fetch('chatbot.php', { 
            method: 'POST', 
            headers: {'Content-Type':'application/json'}, 
            body: JSON.stringify({input: userInput}) 
        });
        
        const data = await res.json();
        const botResp = data.plan || 'Lo siento, no se recibió respuesta.';
        
        log.innerHTML += `<p><b>GymBot:</b> ${escapeHtml(botResp)}</p>`;
    } catch (err) {
        console.error(err);
        log.innerHTML += `<p><b>GymBot:</b> Hubo un error al contactar el servidor.</p>`;
    }
    
    inputElement.value = ''; 
    log.scrollTop = log.scrollHeight; 
}

function escapeHtml(text){ 
    return text.replace(/[&<>"']/g, function(m){
        return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[m]; 
    }); 
}

function toggleChat() {
    const chatWindow = document.getElementById("chat-window");
    const toggleButton = document.getElementById("chat-toggle-button");
    
    // Si ves este mensaje en la Consola al hacer clic, ¡la función se ejecuta!
    console.log("Función toggleChat ejecutada."); 

    if (chatWindow.style.display === "none" || chatWindow.style.display === "") {
        chatWindow.style.display = "block";
        toggleButton.textContent = "Cerrar Chat";
    } else {
        chatWindow.style.display = "none";
        toggleButton.textContent = "Abrir Chat";
    }
}


// 🚀 LÓGICA DE INICIALIZACIÓN Y ASIGNACIÓN DE EVENTOS (Auto-ejecutable)
// Esto se ejecuta inmediatamente al final del <body>, garantizando la asignación.
(function() {
    const inputElement = document.getElementById("user-input");
    const toggleButton = document.getElementById("chat-toggle-button");

    if (toggleButton) {
        console.log("Asignando evento 'click' al botón del chat.");
        toggleButton.addEventListener('click', toggleChat);
    } else {
        // Esto aparecería si el HTML del botón no existe.
        console.error("Fallo de asignación: Elemento #chat-toggle-button no encontrado al cargar."); 
    }
    
    // Lógica para el envío con 'Enter'
    if(inputElement) {
        inputElement.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
                e.preventDefault(); 
            }
        });
    }
})();