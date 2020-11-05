<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include("./core/mysqli/query.php");
include("./helpers/response.php");

$mahasiswa = new Query("mahasiswa");


$method_page = $_SERVER["REQUEST_METHOD"];
$response = array();

switch ($method_page) {
    case "GET":
        $data = $mahasiswa->all();
        while ($row = $data->fetch_assoc()) {
            $result[] = $row;
        }
        $response["status"] = 200;
        $response["data"] = $result;
        break;
    case "POST":
        $data['nama'] = $_POST['nama'];
        $data['nim'] = $_POST['nim'];
        $data['jurusan'] = $_POST['jurusan'];
        $insert = $mahasiswa->insert($data);
        if ($insert === true) {
            $response["status"] = 200;
            $response["message"] = "Insert Data Success";
        } else {
            $response["status"] = 500;
            $response["message"] = "Insert Data Error";
        }
        break;
    case "PUT":
        $data['id'] = $_POST['id'];
        $data['nama'] = $_POST['nama'];
        $data['nim'] = $_POST['nim'];
        $data['jurusan'] = $_POST['jurusan'];
        $mahasiswa->where('id', $data['id']);
        $update = $mahasiswa->update($data);
        if ($update === true) {
            $response["status"] = 200;
            $response["message"] = "Update Data Success";
        } else {
            $response["status"] = 500;
            $response["message"] = "Update Data Error";
        }
        break;
    case "DELETE":
        $id = $_GET['id'];
        if (isset($id)) {
            $mahasiswa->delete(['id' => $id]);
            $response["status"] = 200;
            $response["message"] = "Delete Data Success";
        } else {
            $response["status"] = 404;
            $response["message"] = "Delete Data Not Found";
        }
        break;
    default:
        $data = $mahasiswa->all();
        while ($row = $data->fetch_assoc()) {
            $result[] = $row;
        }
        $response["status"] = 200;
        $response["data"] = $result;;
        break;
}

echo json_encode($response);
