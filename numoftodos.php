<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
	$conn = new PDO("sqlite:file:todo.db?mode=rwc");
	$conn->exec("CREATE TABLE IF NOT EXISTS todo(todo_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, todo_item TEXT NOT NULL)");
		
	$stmt = $conn->prepare("SELECT * FROM todo");
	$stmt->execute();
	$rows = $stmt->fetchall();

	echo count($rows);
	exit;
}

header("HTTP/1.1 405 Method Not Allowed");
echo "405 Method Not Allowed";
exit;
?>