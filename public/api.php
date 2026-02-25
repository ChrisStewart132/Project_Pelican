<?php
// api.php
header('Content-Type: application/json');
require_once 'config.php';
require_once 'database.php';
$pdo = getDatabaseConnection(); // Initialize the connection

$method = $_SERVER['REQUEST_METHOD'];

// --- HANDLE GET REQUESTS (Frontend & Admin reading data) ---
if ($method === 'GET') {
    $type = $_GET['type'] ?? '';
    try {
        switch ($type) {
            case 'system':
                $stmt = $pdo->query('SELECT * FROM system_prompts');
                echo json_encode($stmt->fetchAll());
                break;
            case 'architect':
                $stmt = $pdo->query('SELECT * FROM architect_prompts');
                echo json_encode($stmt->fetchAll());
                break;
            case 'project':
                $stmt = $pdo->query('SELECT * FROM project_prompts');
                echo json_encode($stmt->fetchAll());
                break;
            case 'interfaces':
                $stmt = $pdo->query('SELECT * FROM code_interfaces');
                echo json_encode($stmt->fetchAll());
                break;
            default:
                echo json_encode(['error' => 'Invalid GET request type.']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

// --- HANDLE POST REQUESTS (Admin adding/editing data) ---
if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Simple Authentication Check
    if (!isset($data['secret']) || $data['secret'] !== $admin_secret) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized: Invalid Admin Password']);
        exit;
    }

    $id = $data['id'] ?? null; // If ID is provided, we are editing.
    $type = $data['type'] ?? '';
    $title = trim($data['title'] ?? '');
    $content = trim($data['content'] ?? '');
    $deps = trim($data['dependencies'] ?? '');

    if (empty($title) || empty($content)) {
        http_response_code(400);
        echo json_encode(['error' => 'Title and Content are required.']);
        exit;
    }

    try {
        if ($id) {
            // --- UPDATE EXISTING RECORD ---
            switch ($type) {
                case 'system':
                    $stmt = $pdo->prepare('UPDATE system_prompts SET title=?, content=? WHERE id=?');
                    $stmt->execute([$title, $content, $id]);
                    break;
                case 'architect':
                    $stmt = $pdo->prepare('UPDATE architect_prompts SET title=?, content=? WHERE id=?');
                    $stmt->execute([$title, $content, $id]);
                    break;
                case 'project':
                    $stmt = $pdo->prepare('UPDATE project_prompts SET title=?, content=? WHERE id=?');
                    $stmt->execute([$title, $content, $id]);
                    break;
                case 'interfaces':
                    $stmt = $pdo->prepare('UPDATE code_interfaces SET title=?, content=?, dependencies=? WHERE id=?');
                    $stmt->execute([$title, $content, $deps, $id]);
                    break;
                default:
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid POST request type.']);
                    exit;
            }
            echo json_encode(['success' => true, 'message' => 'Record updated successfully!']);
        } else {
            // --- INSERT NEW RECORD ---
            switch ($type) {
                case 'system':
                    $stmt = $pdo->prepare('INSERT INTO system_prompts (title, content) VALUES (?, ?)');
                    $stmt->execute([$title, $content]);
                    break;
                case 'architect':
                    $stmt = $pdo->prepare('INSERT INTO architect_prompts (title, content) VALUES (?, ?)');
                    $stmt->execute([$title, $content]);
                    break;
                case 'project':
                    $stmt = $pdo->prepare('INSERT INTO project_prompts (title, content) VALUES (?, ?)');
                    $stmt->execute([$title, $content]);
                    break;
                case 'interfaces':
                    $stmt = $pdo->prepare('INSERT INTO code_interfaces (title, content, dependencies) VALUES (?, ?, ?)');
                    $stmt->execute([$title, $content, $deps]);
                    break;
                default:
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid POST request type.']);
                    exit;
            }
            echo json_encode(['success' => true, 'message' => 'Record created successfully!']);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database Error: ' . $e->getMessage()]);
    }
    exit;
}

echo json_encode(['error' => 'Method not allowed.']);
?>