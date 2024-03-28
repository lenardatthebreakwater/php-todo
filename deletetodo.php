<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$json_data = file_get_contents('php://input', false);

	if (!empty($json_data)) {
		$conn = new PDO("sqlite:file:todo.db?mode=rwc");

		$todosToBeDeleted = json_decode($json_data, true);

		//print_r($todosToBeDeleted);

		for ($i = 0; $i < count($todosToBeDeleted); $i++) {
			$stmt = $conn->prepare("DELETE FROM todo WHERE todo_id=:todo_id");
			$stmt->bindParam(":todo_id", $todosToBeDeleted[$i]["todoID"]);
			$stmt->execute();
		}

		$stmt = $conn->prepare("SELECT * FROM todo");
		$stmt->execute();
		$rows = $stmt->fetchall();

		//print_r(var_dump($rows));

		$remainingTodos = [];
		for ($i = 0; $i < count($rows); $i++) {
			$remainingTodos[$rows[$i]["todo_id"]] = $rows[$i]["todo_item"];
		}

		//print_r(var_dump($remainingTodos));

		$conn = null;
		$stmt = null;

		header('Content-Type: application/json');
		echo json_encode($remainingTodos);
		exit;
	}

	header("HTTP/1.1 418 I'm a teapot");
	echo "418 I'm a teapot";
	exit;
}

header("HTTP/1.1 405 Method Not Allowed");
echo "405 Method Not Allowed";
exit;
?>