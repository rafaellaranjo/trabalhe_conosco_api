<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Origin: http://localhost:5173');
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once './controllers/AuthController.php';
require_once './controllers/UserController.php';
require_once './controllers/JobController.php';
require_once './controllers/CandidateController.php';
require_once './controllers/CandidateJobController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$defaultLimit = 20;

$router = [
    '/auth' => AuthController::class,
    '/users' => UserController::class,
    '/jobs' => JobController::class,
    '/candidates' => CandidateController::class,
    '/candidate_job' => CandidateJobController::class,
];

$resource = explode('/', trim($uri, '/'))[0];
$resourceId = explode('/', trim($uri, '/'))[1] ?? null;

if (array_key_exists("/$resource", $router)) {
    $controller = new $router["/$resource"]();

    switch ($method) {
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            if ($resourceId === null) {
                $result = $controller->create($data);
            } else if ($resourceId == 'signin') {
                $result = $controller->signin($data);
            } else {
                echo json_encode(['error' => 'Invalid request']);
                exit;
            }
            break;

        case 'GET':
            $limit = $_GET['limit'] ?? $defaultLimit;
            $page = $_GET['page'] ?? 1;
            $orderBy = $_GET['orderBy'] ?? 'id';
            $orderDir = $_GET['orderDir'] ?? 'ASC';

            if ($resourceId === null) {
                $result = $controller->findAll($limit, $page, $orderBy, $orderDir);
            } else {
                $result = $controller->findById($resourceId);
            }
            break;

        case 'PATCH':
            if ($resourceId !== null) {
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $controller->updatePartial($resourceId, $data);
            } else {
                echo json_encode(['error' => 'Invalid request']);
                exit;
            }
            break;

        case 'DELETE':
            $data = json_decode(file_get_contents('php://input'), true);
            if ($resourceId !== null) {
                $result = $controller->delete($resourceId);
            } elseif (isset($data['ids'])) {
                $result = $controller->deleteMultiple($data['ids']);
            } else {
                echo json_encode(['error' => 'Invalid request']);
                exit;
            }
            break;

        default:
            echo json_encode(['error' => 'Method not allowed']);
            exit;
    }

    header('Content-Type: application/json');
    echo json_encode($result);

} else {
    echo json_encode(['error' => 'Route not found']);
}
?>
