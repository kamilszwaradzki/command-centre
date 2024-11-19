<?php

$request = $_SERVER['REQUEST_URI'];
$viewDir = '/src/pages/';

switch ($request) {
    case '':
    case '/':
        require_once __DIR__ . '/home.php';
        break;
    case '/business':
        require_once __DIR__ . $viewDir . 'business.php';
        break;
    case '/business/add':
        require_once __DIR__ . '/src/business/Controller.php';
        $controller = new Business\Controller();
        $controller->add();
        header("Location: " . $_POST['redirect_to']);
        die();
        break;
    case '/business/copy':
        require_once __DIR__ . '/src/business/Controller.php';
        $controller = new Business\Controller();
        $controller->copy();
        header("Location: " . $_POST['redirect_to']);
        die();
        break;
    case '/business/edit':
        require_once __DIR__ . '/src/business/Controller.php';
        $controller = new Business\Controller();
        $controller->update();
        header("Location: " . $_POST['redirect_to']);
        die();
        break;
    case '/business/delete':
        require_once __DIR__ . '/src/business/Controller.php';
        $controller = new Business\Controller();
        $controller->delete();
        header("Location: " . $_POST['redirect_to']);
        die();
        break;
    case '/hobby':
        require_once __DIR__ . $viewDir . 'hobby.php';
        break;
    case '/hobby/copy':
        require_once __DIR__ . '/src/hobby/Controller.php';
        $controller = new Hobby\Controller();
        $controller->copy();
        header("Location: " . $_POST['redirect_to']);
        die();
        break;
    case '/hobby/add':
        require_once __DIR__ . '/src/hobby/Controller.php';
        $controller = new Hobby\Controller();
        $controller->add();
        header("Location: " . $_POST['redirect_to']);
        die();
        break;
    case '/hobby/edit':
        require_once __DIR__ . '/src/hobby/Controller.php';
        $controller = new Hobby\Controller();
        $controller->update();
        header("Location: " . $_POST['redirect_to']);
        die();
        break;
    case '/hobby/delete':
        require_once __DIR__ . '/src/hobby/Controller.php';
        $controller = new Hobby\Controller();
        $controller->delete();
        header("Location: " . $_POST['redirect_to']);
        die();
        break;
    case '/todo':
        require_once __DIR__ . $viewDir . 'todo.php';
        break;
    case '/todo/api/get':
        require_once __DIR__ . '/src/todo/Api.php';
        $controller = new Todo\Api();
        $controller->getUnfinishedTodo();
        die();
        break;
    case '/todo/copy':
        require_once __DIR__ . '/src/todo/Controller.php';
        $controller = new Todo\Controller();
        $controller->copy();
        header("Location: " . $_POST['redirect_to']);
        die();
        break;
    case '/todo/add':
        require_once __DIR__ . '/src/todo/Controller.php';
        $controller = new Todo\Controller();
        $controller->add();
        header("Location: " . $_POST['redirect_to']);
        die();
        break;
    case '/todo/edit':
        require_once __DIR__ . '/src/todo/Controller.php';
        $controller = new Todo\Controller();
        $controller->update();
        header("Location: " . $_POST['redirect_to']);
        die();
        break;
    case '/todo/delete':
        require_once __DIR__ . '/src/todo/Controller.php';
        $controller = new Todo\Controller();
        $controller->delete();
        header("Location: " . $_POST['redirect_to']);
        die();
        break;
    default:
        if (file_exists(__DIR__ . $request)) {
            header('Content-Description: File Transfer');
            header('Content-Type: ' . mime_content_type(basename($request)));
            header('Content-Disposition: attachment; filename='.basename($request));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize(__DIR__ . $request));
            ob_clean();
            flush();
            readfile(__DIR__ . $request);
            exit;
        } else {
            http_response_code(404);
            require __DIR__ . $viewDir . '404.php';
        }
}