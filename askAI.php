

<?php
// Development only — remove these 3 lines in production
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Always return JSON
header("Content-Type: application/json");

// ✅ Replace with your actual Gemini API key
$apiKey = "AIzaSyAyX4TwprbWm3I29iF09N3VWM7tvqWkdAQ";

// Gemini API endpoint
$endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";

// Get and sanitize question
$input = json_decode(file_get_contents("php://input"), true);
$question = trim($input['question'] ?? '');

if (!$question) {
    echo json_encode(["error" => "No question provided."]);
    exit;
}

// Prepare payload
$postData = [
    "contents" => [
        [
            "parts" => [
                ["text" => $question]
            ]
        ]
    ]
];

// Send request to Gemini
$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

$response = curl_exec($ch);
$httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

// Handle cURL error
if ($curlError) {
    echo json_encode(["error" => "cURL Error: $curlError"]);
    exit;
}

// Handle HTTP error
if ($httpStatus !== 200) {
    echo json_encode([
        "error" => "Gemini API error",
        "status" => $httpStatus,
        "response" => json_decode($response, true)
    ]);
    exit;
}

// Extract AI response safely
$data = json_decode($response, true);
$answer = $data['candidates'][0]['content']['parts'][0]['text'] ?? "No valid response from AI.";

// Return clean JSON
echo json_encode(["answer" => $answer]);
?>
