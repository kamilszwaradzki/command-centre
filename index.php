<?php

$request = $_SERVER['REQUEST_URI'];
$viewDir = '/src/pages/';

switch ($request) {
    case '':
    case '/':
        require_once __DIR__ . '/home.php';
        break;
    case '/business':
    case '/business/add':
    case '/business/copy':
    case '/business/edit':
    case '/business/delete':
        require_once __DIR__ . '/src/business/Controller.php';
        $controller = new Business\Controller();
        if (str_ends_with($request, '/add')) {
            $controller->add();
            header("Location: " . $_POST['redirect_to']);
            die();
        } else if (str_ends_with($request, '/copy')) {
            $controller->copy();
            header("Location: " . $_POST['redirect_to']);
            die();
        } else if (str_ends_with($request, '/edit')) {
            $controller->update();
            header("Location: " . $_POST['redirect_to']);
            die();
        } else if (str_ends_with($request, '/delete')) {
            $controller->delete();
            header("Location: " . $_POST['redirect_to']);
            die();
        } else {
            require_once __DIR__ . $viewDir . 'business.php';
        }
        break;
    case '/hobby':
    case '/hobby/copy':
    case '/hobby/add':
    case '/hobby/edit':
    case '/hobby/delete':
        require_once __DIR__ . '/src/hobby/Controller.php';
        $controller = new Hobby\Controller();
        if (str_ends_with($request, '/add')) {
            $controller->add();
            header("Location: " . $_POST['redirect_to']);
            die();
        } else if (str_ends_with($request, '/copy')) {
            $controller->copy();
            header("Location: " . $_POST['redirect_to']);
            die();
        } else if (str_ends_with($request, '/edit')) {
            $controller->update();
            header("Location: " . $_POST['redirect_to']);
            die();
        } else if (str_ends_with($request, '/delete')) {
            $controller->delete();
            header("Location: " . $_POST['redirect_to']);
            die();
        } else {
            require_once __DIR__ . $viewDir . 'hobby.php';
        }
        break;
    case '/todo':
    case '/todo/api/get':
    case '/todo/copy':
    case '/todo/add':
    case '/todo/edit':
    case '/todo/delete':
        require_once __DIR__ . '/src/todo/Controller.php';
        $controller = new Todo\Controller();
        if (str_ends_with($request, '/add')) {
            $controller->add();
            header("Location: " . $_POST['redirect_to']);
            die();
        } else if (str_ends_with($request, '/copy')) {
            $controller->copy();
            header("Location: " . $_POST['redirect_to']);
            die();
        } else if (str_ends_with($request, '/edit')) {
            $controller->update();
            header("Location: " . $_POST['redirect_to']);
            die();
        } else if (str_ends_with($request, '/delete')) {
            $controller->delete();
            header("Location: " . $_POST['redirect_to']);
            die();
        } else if (str_ends_with($request, '/api/get')) {
            require_once __DIR__ . '/src/todo/Api.php';
            $controller = new Todo\Api();
            $controller->getUnfinishedTodo();
            die();
        } else {
            require_once __DIR__ . $viewDir . 'todo.php';
        }
        break;
    case '/invoice':
    case '/invoice/print':
    case '/invoice/copy':
    case '/invoice/add':
    case '/invoice/edit':
    case '/invoice/delete':
        require_once __DIR__ . '/src/invoice/Controller.php';
        $controller = new Invoice\Controller();
        if (str_ends_with($request, '/add')) {
            $controller->add();
            header("Location: " . $_POST['redirect_to']);
            die();
        } else if (str_ends_with($request, '/copy')) {
            $controller->copy();
            header("Location: " . $_POST['redirect_to']);
            die();
        } else if (str_ends_with($request, '/edit')) {
            $controller->update();
            header("Location: " . $_POST['redirect_to']);
            die();
        } else if (str_ends_with($request, '/delete')) {
            $controller->delete();
            header("Location: " . $_POST['redirect_to']);
            die();
        } else if (str_ends_with($request, '/print')) {
            $invoice_collection = $controller->print();
            require_once __DIR__ . $viewDir . 'invoice_view.php';
            die();
        } else {
            require_once __DIR__ . $viewDir . 'invoice.php';
        }
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