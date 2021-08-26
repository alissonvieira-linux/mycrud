<?php
// header('Content-Type: application/json');

require __DIR__.'/vendor/autoload.php';

use \App\Models\User;

$obj = new User();
var_dump($obj->select());

// if ($_GET['url']) {
//     $url = explode('/', $_GET['url']);

//     if ($url[0] === 'api') {
//         array_shift($url);

//         $controller = 'App\Services\\'.ucfirst($url[0]).'Service';
//         array_shift($url);

//         if (isset($url[1]) && $url[1] === 'delete') {
//             $method = 'delete';
//         } else {
//             $method = strtolower($_SERVER['REQUEST_METHOD']);
//         }

//         try {
//             $response = call_user_func_array(array(new $service, $method), $url);

//             http_response_code(200);
//             echo json_encode(array('status'=>'success', 'data'=>$response));
//             exit;
//         } catch (\Exception $e) {
//             http_response_code(404);
//             echo json_encode(array('status'=>'error', 'data'=>$e->getMessage()), JSON_UNESCAPED_UNICODE);
//             exit;
//         }
//     }
// }