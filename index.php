<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type, X-Session-ID');
header('Access-Control-Expose-Headers: X-Session-ID');


use App\Exceptions\PageNotFound;

require __DIR__ . '/autoload.php';

if (isset($_SERVER['HTTP_X_SESSION_ID'])){
    $session_id = $_SERVER['HTTP_X_SESSION_ID'];
    session_id($session_id);
}

session_start(); // Инициализируем сессию

$params = explode('/', $_SERVER['REQUEST_URI']);

$controller = isset($params[1]) ? $params[1] : null;
$action = isset($params[2]) ? $params[2] : null;
$id = isset($params[3]) ? $params[3] : null;

// $params[4-...] other parameters

//Объект конфигурации
$config = \App\Config::getInstace();

//Создаем основной логер
$mainlogger = new \App\Logger($config->data['log']['mainLog']);

//Создаем Роутер
$router = new \Bramus\Router\Router();

$router->options('/.*', function() {
    // Возвращаем успешный ответ
    http_response_code(200);
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // Указываем допустимые методы для CORS-запросов
    header('Access-Control-Allow-Headers: Content-Type, X-Session-ID'); // Указываем дополнительные заголовки, которые разрешены для CORS-запросов
    header('Access-Control-Expose-Headers: X-Session-ID'); // Указываем заголовки, которые разрешено выставлять на клиентскую сторону
});

// Включаем обработку предварительных OPTIONS-запросов
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Возвращаем успешный ответ
    http_response_code(200);
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // Указываем допустимые методы для CORS-запросов
    header('Access-Control-Allow-Headers: Content-Type, X-Session-ID'); // Указываем дополнительные заголовки, которые разрешены для CORS-запросов
    header('Access-Control-Expose-Headers: X-Session-ID'); // Указываем заголовки, которые разрешено выставлять на клиентскую сторону
    exit();
}

$router->get('/logout', function() {
    // Очищаем информацию о пользователе из сессии
    unset($_SESSION['user']);
    http_response_code(200);
    echo 'Выход выполнен успешно';
    return;
});

// Добавляем маршруты для авторизации и выхода
$router->post('/login', function() {
    // Проверяем логин и пароль
    if ($_POST['username'] === 'user' && $_POST['password'] === 'pass') {
        // Если авторизация успешна, сохраняем информацию о пользователе в сессии
        $_SESSION['user'] = [
            'username' => $_POST['username']
        ];
        // Возвращаем успешный ответ
        http_response_code(200);
        header('X-Session-ID: ' . session_id());
        echo 'Авторизация прошла успешно';
        return;
    } else {
        // Если логин и пароль неверны, возвращаем 401 Unauthorized
        http_response_code(401);
        echo 'Неверный логин или пароль';
        return;
    }
});

if (strlen($controller) > 0) {
    try {
        $router->get($_SERVER['REQUEST_URI'], \App\Helpers\RouterHelper::goToRoute($controller, $action, $id));
    } catch (\App\Exceptions\PageNotFound $e){
        $router->trigger404();
    }
}

$router->get("/api/\w+/\w+", function (){
    if (!isset($_SESSION['user'])) {
        // Если пользователь не авторизован, возвращаем 401 Unauthorized
        http_response_code(401);
        echo 'Вы не авторизованы';
        return;
    }
    \App\Helpers\ApiRouteHelper::runAction();
});

$router->get("/api/\w+/", function (){
    if (!isset($_SESSION['user'])) {
        // Если пользователь не авторизован, возвращаем 401 Unauthorized
        http_response_code(401);
        echo 'Вы не авторизованы';
        return;
    }
    \App\Helpers\ApiRouteHelper::runAction();
});


///Обработка 404
$router->set404(function() {
    http_response_code(404);
});


/////Главная страница
$router->get('', function (){
    $controller = new \App\Controllers\Index();
    $controller->action("main");
});

try {
    $router->run();
} catch (\App\Exceptions\ApiNotFound $e){
    http_response_code(404);
    echo 'api not found';
}


