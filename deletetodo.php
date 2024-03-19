<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$todo_id = htmlspecialchars($_GET["todo_id"]);

	if (!empty($todo_id) & (int) $_GET["todo_id"] != 0) {
		$conn = new PDO("sqlite:file:todo.db?mode=rwc");

		$stmt = $conn->prepare("DELETE FROM todo WHERE todo_id=:todo_id");
		$stmt->bindParam(":todo_id", $todo_id);
		$stmt->execute();

		$conn = null;
		$stmt = null;

		header("Location: index.php");
		exit;
	}

	header("HTTP/1.1 418 I'm a teapot");
	exit;
}

header("HTTP/1.1 405 Method Not Allowed");
exit;
?>