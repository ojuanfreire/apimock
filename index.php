<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

require_once 'database.php';

function find_by_id($array, $id) {
    foreach ($array as $item) {
        if (isset($item['id']) && $item['id'] == $id) {
            return $item;
        }
    }
    return null;
}

function delete_by_id($array, $id) {
    foreach ($array as $key => $item) {
        if (isset($item['id']) && $item['id'] == $id) {
            unset($array[$key]);
            return array_values($array);
        }
    }
    return null;
}

function update_by_id($array, $id, $newData) {
    foreach ($array as $key => $item) {
        if (isset($item['id']) && $item['id'] == $id) {
            $array[$key] = array_merge($item, $newData);
            return $array[$key];
        }
    }
    return null;
}

$request_method = $_SERVER["REQUEST_METHOD"];
$request_uri = $_SERVER['REQUEST_URI'];
$path = str_replace('/api-comissao', '', $request_uri);

$resource = null;
$resource_id = null;

if (preg_match('#^/api/([^/]+)/?(\d+)?#', $path, $matches)) {
    $resource = $matches[1];
    $resource_id = isset($matches[2]) ? $matches[2] : null;
}

$data_map = [
    'users' => $users,
    'commission-rules' => $commissionRules,
    'goals' => $goals
];

if (!$resource || !isset($data_map[$resource])) {
    http_response_code(404);
    echo json_encode(["erro" => "Recurso não encontrado."]);
    exit();
}

$resource_data = &$data_map[$resource];

switch ($request_method) {
    case 'GET':
        if ($resource_id) {
            $item = find_by_id($resource_data, $resource_id);
            if ($item) {
                echo json_encode($item);
            } else {
                http_response_code(404);
                echo json_encode(["erro" => "Item com ID $resource_id não encontrado."]);
            }
        } else {
            echo json_encode($resource_data);
        }
        break;

    case 'POST':
        $json_data = file_get_contents('php://input');
        $newData = json_decode($json_data, true);
        $newData['id'] = rand(100, 999);
        $resource_data[] = $newData;
        http_response_code(201);
        echo json_encode($newData);
        break;

    case 'PUT':
        if (!$resource_id) {
            http_response_code(400);
            echo json_encode(["erro" => "ID do recurso não especificado para atualização."]);
            exit();
        }
        $json_data = file_get_contents('php://input');
        $updateData = json_decode($json_data, true);
        $updatedItem = update_by_id($resource_data, $resource_id, $updateData);
        if ($updatedItem) {
            echo json_encode($updatedItem);
        } else {
            http_response_code(404);
            echo json_encode(["erro" => "Item com ID $resource_id não encontrado para atualizar."]);
        }
        break;

    case 'DELETE':
        if (!$resource_id) {
            http_response_code(400);
            echo json_encode(["erro" => "ID do recurso não especificado para exclusão."]);
            exit();
        }
        $result = delete_by_id($resource_data, $resource_id);
        if ($result !== null) {
            http_response_code(200);
            echo json_encode(["sucesso" => "Item com ID $resource_id foi excluído."]);
        } else {
            http_response_code(404);
            echo json_encode(["erro" => "Item com ID $resource_id não encontrado para excluir."]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["erro" => "Método não permitido."]);
        break;
}
?>