const chatContainer = document.getElementById("chat-container");
const chatBody = document.getElementById("chat-body");

document.getElementById("chat-toggle").onclick = toggleChat;

// Mantener abierto con localStorage
if (localStorage.getItem("chat_open") === "true") {
    chatContainer.style.display = "flex";
}

function guardarEstado(open) {
    localStorage.setItem("chat_open", open);
}

function toggleChat() {
    let isOpen = chatContainer.style.display === "flex";
    chatContainer.style.display = isOpen ? "none" : "flex";
    guardarEstado(!isOpen);
}

//Enviar mensaje
function enviarMensaje() {
    let input = document.getElementById("chat-input");
    let mensaje = input.value.trim();

    if (!mensaje) return;

    agregarMensaje(mensaje, "user");
    input.value = "";

    //mensaje "escribiendo..."
    let typing = agregarMensaje("Escribiendo...", "bot");
    let historial = JSON.parse(localStorage.getItem("chat_historial")) || [];

    fetch("api/chatbot.php", {
        method: "POST",
        body: new URLSearchParams({
            mensaje,
            historial: JSON.stringify(historial)
        })
    })
        .then(res => res.json())
        .then(data => {

            //eliminar "escribiendo..."
            typing.remove();

            let respuesta = data.respuesta || "No se obtuvo respuesta";

            agregarMensaje(respuesta, "bot");
        })
        .catch(err => {
            typing.remove();
            agregarMensaje("Error al conectar con el servidor", "bot");
            console.error(err);
        });
}

//Mostrar mensajes
function agregarMensaje(texto, tipo) {

    let div = document.createElement("div");
    div.classList.add("message", tipo);
    div.innerText = texto;

    chatBody.appendChild(div);
    chatBody.scrollTop = chatBody.scrollHeight;

    //NO guardar mensajes temporales
    if (texto === "Escribiendo..." || texto.includes("Error")) {
        return div;
    }

    let historial = JSON.parse(localStorage.getItem("chat_historial")) || [];

    historial.push({ texto, tipo });

    localStorage.setItem("chat_historial", JSON.stringify(historial));

    return div;
}

function nuevoChat() {
    // borrar almacenamiento
    localStorage.removeItem("chat_historial");

    // limpiar UI
    chatBody.innerHTML = "";

    // mensaje inicial
    agregarMensaje("🔄 Nuevo chat iniciado. ¿En qué puedo ayudarte?", "bot");
}

//Enviar con ENTER
document.getElementById("chat-input")
    .addEventListener("keypress", function (e) {
        if (e.key === "Enter") enviarMensaje();
    });

//Mensaje inicial automático
window.onload = () => {

    let historial = JSON.parse(localStorage.getItem("chat_historial")) || [];

    chatBody.innerHTML = "";

    let mensajesUnicos = new Set();

    historial.forEach(msg => {
        let key = msg.texto + msg.tipo;

        if (!mensajesUnicos.has(key)) {
            mensajesUnicos.add(key);

            let div = document.createElement("div");
            div.classList.add("message", msg.tipo);
            div.innerText = msg.texto;
            chatBody.appendChild(div);
        }
    });
};