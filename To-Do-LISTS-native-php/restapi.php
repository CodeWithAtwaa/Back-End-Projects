<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
include("Database/db.php");
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    // ----------------GET ALL TASK --------------------------
    case 'GET':
        $state = $connect->prepare("SELECT * FROM task");
        $state->execute();
        echo json_encode($state->fetchAll(PDO::FETCH_ASSOC));
        break;
    // ----------------ADD A NEW TASK --------------------------
    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);
        $state = $connect->prepare("INSERT INTO task (task_name, status, created_at) VALUES (?, ?, NOW())");
        if ($state->execute([$data['task_name'], $data['status']])) {
            echo json_encode([
                "status" => "success",
                "message" => "Task created successfully"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Failed to insert"
            ]);
        }
        break;
    // ----------------UPDATE A SPECIFIC TASK --------------------------
    case "PUT":
        $data = json_decode(file_get_contents("php://input"), true);
        $state = $connect->prepare("UPDATE task SET task_name = ?, status = ?, updated_at = NOW() WHERE task_id = ?");
        if ($state->execute([$data['task_name'], $data['status'], $data['task_id']])) {
            echo json_encode([
                "status" => "success",
                "message" => "Task updated successfully"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Failed to update"
            ]);
        }
        break;
    // ----------------DELETE A TASK --------------------------
    case "DELETE":
        $data = json_decode(file_get_contents("php://input"), true);
        $state = $connect->prepare("DELETE FROM task WHERE task_id = ?");
        if ($state->execute([$data['task_id']])) {
            echo json_encode([
                "status" => "success",
                "message" => "Task deleted successfully"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Failed to delete"
            ]);
        }
        break;
    default:
        echo json_encode([
            "status" => "error",
            "message" => "Method not allowed"
        ]);
}
?>