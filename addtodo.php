<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$todo_item = htmlspecialchars($_POST["todo_item"]);

	if (!empty($todo_item)) {
		$conn = new PDO("sqlite:file:todo.db?mode=rwc");

		$conn->exec("CREATE TABLE IF NOT EXISTS todo(todo_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, todo_item TEXT NOT NULL)");

		$stmt = $conn->prepare("INSERT INTO todo (todo_item) VALUES (:todo_item)");
		$stmt->bindParam(":todo_item", $todo_item);
		$stmt->execute();

		$conn = null;
		$stmt = null;

		header("Location: index.php");
		exit;
	}

	header("Location: index.php");
	exit;
}

header("HTTP/1.1 405 Method Not Allowed");
echo "405 Method Not Allowed";
exit;
?>