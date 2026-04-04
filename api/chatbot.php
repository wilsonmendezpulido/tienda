<?php
header("Content-Type: application/json");

//Conexión
include '../incluir/conexion.php';
$historial = $_POST['historial'] ?? '[]';

if (!$conexion) {
    echo json_encode(["error" => "Error de conexión a la base de datos"]);
    exit;
}

//Validar entrada
$mensaje = $_POST['mensaje'] ?? '';

if (empty(trim($mensaje))) {
    echo json_encode(["error" => "Mensaje vacío"]);
    exit;
}

//1. Buscar productos
$stmt = $conexion->prepare("SELECT nombre, precio, stock, descripcion FROM productos WHERE nombre LIKE ? LIMIT 5");

if (!$stmt) {
    echo json_encode(["error" => "Error en consulta productos"]);
    exit;
}

$like = "%$mensaje%";
$stmt->bind_param("s", $like);
$stmt->execute();

$result = $stmt->get_result();

$productos = "";
$palabras = explode(" ", $mensaje);
//$filtrado = array_diff($palabras, $stopwords);

foreach ($palabras as $palabra) {
    $like = "%$palabra%";

    $stmt = $conexion->prepare("SELECT nombre, precio, stock, descripcion FROM productos WHERE nombre LIKE ? LIMIT 5");
    $stmt->bind_param("s", $like);
    $stmt->execute();

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $productos .= "🛒 {$row['nombre']} | 💰 {$row['precio']} | 📦 {$row['stock']}\n";
    }
}

// RESPUESTA RÁPIDA SIN IA (optimización)
if (!empty($productos)) {
    echo json_encode([
        "respuesta" => $productos
    ]);
    exit;
}

//2. Buscar FAQs
$stmtFaq = $conexion->prepare("SELECT pregunta, respuesta FROM faq WHERE pregunta LIKE ? LIMIT 3");

if (!$stmtFaq) {
    echo json_encode(["error" => "Error en consulta FAQ"]);
    exit;
}

$stmtFaq->bind_param("s", $like);
$stmtFaq->execute();

$resultFaq = $stmtFaq->get_result();

$faqs = "";

while ($row = $resultFaq->fetch_assoc()) {
    $faqs .= "❓ {$row['pregunta']}\n💬 {$row['respuesta']}\n";
}

//3. Contexto para IA
$contexto = "INFORMACIÓN DISPONIBLE:\n\nPRODUCTOS:\n" . ($productos ?: "No hay productos.\n") .
    "\nFAQ:\n" . ($faqs ?: "No hay información.\n");

//4. API KEY
//$apiKey = ""; descomenta y pon tu api aca.

//5. Preparar request
$data = [
    "model" => "gpt-4o-mini",
    "messages" => [
        [
            "role" => "system",
            "content" => "Eres un asistente de ecommerce. Responde SOLO con la información proporcionada. Si no tienes datos, responde: 'No tengo esa información'. Sé claro, breve y amigable."
        ],
        [
            "role" => "user",
            "content" => $contexto . "\n\nUsuario: " . $mensaje
        ]
    ]
];

//6. Llamada API con cURL
$ch = curl_init("https://api.openai.com/v1/chat/completions");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey"
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Ejecutar
$response = curl_exec($ch);

//Error cURL
if (curl_errno($ch)) {
    echo json_encode([
        "error" => "Error CURL",
        "detalle" => curl_error($ch)
    ]);
    exit;
}

curl_close($ch);

//Procesar respuesta
$result = json_decode($response, true);

//Error OpenAI
if (isset($result['error'])) {
    echo json_encode([
        "error" => "Error OpenAI",
        "detalle" => $result['error']['message']
    ]);
    exit;
}

//Validar contenido
if (!isset($result['choices'][0]['message']['content'])) {
    echo json_encode([
        "error" => "Respuesta inválida",
        "debug" => $result
    ]);
    exit;
}

//RESPUESTA FINAL LIMPIA
echo json_encode([
    "respuesta" => $result['choices'][0]['message']['content']
]);
