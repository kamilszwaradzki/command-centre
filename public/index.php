<?php
// public/index.php

require_once __DIR__ . '/../vendor/autoload.php';

session_start();
// error_reporting(E_ALL); ini_set('display_errors', 1);  // dev only

use Core\Router;

// Inicjujemy router i definiujemy trasy
$router = new Router();

$router->add('GET',  '/', 'Modules\Home\Controller', 'index');

// ── Business ────────────────────────────────────────
$router->add('GET',  '/business',       'Modules\Business\Controller', 'index');
$router->add('POST', '/business/add',   'Modules\Business\Controller', 'add');
$router->add('POST', '/business/copy',  'Modules\Business\Controller', 'copy');
$router->add('POST', '/business/edit',  'Modules\Business\Controller', 'update');
$router->add('POST', '/business/delete','Modules\Business\Controller', 'delete');

// ── Hobby ───────────────────────────────────────────
$router->add('GET',  '/hobby',       'Modules\Hobby\Controller', 'index');
$router->add('POST', '/hobby/add',   'Modules\Hobby\Controller', 'add');
$router->add('POST', '/hobby/copy',  'Modules\Hobby\Controller', 'copy');
$router->add('POST', '/hobby/edit',  'Modules\Hobby\Controller', 'update');
$router->add('POST', '/hobby/delete','Modules\Hobby\Controller', 'delete');

// ── Invoice ─────────────────────────────────────────
$router->add('GET',  '/invoice',       'Modules\Invoice\Controller', 'index');
$router->add('GET',  '/invoice/print', 'Modules\Invoice\Controller', 'print');  // zwraca dane + renderuje widok
$router->add('POST', '/invoice/add',   'Modules\Invoice\Controller', 'add');
$router->add('POST', '/invoice/copy',  'Modules\Invoice\Controller', 'copy');
$router->add('POST', '/invoice/edit',  'Modules\Invoice\Controller', 'update');
$router->add('POST', '/invoice/delete','Modules\Invoice\Controller', 'delete');

// ── Resume ──────────────────────────────────────────
$router->add('GET',  '/resume',        'Modules\Resume\Controller', 'index');
$router->add('GET',  '/resume/print',  'Modules\Resume\Controller', 'print');
$router->add('POST', '/resume/add',    'Modules\Resume\Controller', 'add');
$router->add('POST', '/resume/copy',   'Modules\Resume\Controller', 'copy');
$router->add('POST', '/resume/edit',   'Modules\Resume\Controller', 'update');
$router->add('POST', '/resume/delete', 'Modules\Resume\Controller', 'delete');

// ── Todo ────────────────────────────────────────────
$router->add('GET',  '/todo',          'Modules\Todo\Controller', 'index');
$router->add('GET',  '/todo/api/get',  'Modules\Todo\Api',        'getUnfinishedTodo');
$router->add('POST', '/todo/add',      'Modules\Todo\Controller', 'add');
$router->add('POST', '/todo/copy',     'Modules\Todo\Controller', 'copy');
$router->add('POST', '/todo/edit',     'Modules\Todo\Controller', 'update');
$router->add('POST', '/todo/delete',   'Modules\Todo\Controller', 'delete');

// Uruchamiamy
$router->dispatch();