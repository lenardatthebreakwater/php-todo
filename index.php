<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Todo Application in PHP</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<form method="POST" action="/addtodo.php">
		<input type="text" name="todo_item" id="todo_item" autofocus required>
		<button type="submit" hidden>Add Todo Item</button>
	</form>
	
	<?php
	$conn = new PDO("sqlite:file:todo.db?mode=rwc");
	
	$stmt = $conn->prepare("SELECT * FROM todo");
	$stmt->execute();
	$rows = $stmt->fetchall();

	echo "<ul>";
	for ($i = 0; $i < count($rows); $i++) {
		echo "<li value={$rows[$i]["todo_id"]}>{$rows[$i]["todo_item"]}</li>";
	}
	echo "</ul>";

	$conn = null;
	$stmt = null;
	?>

	<button id="deleteTodosBtn">Clear Completed</button>

	<script src="index.js"></script>
</body>
</html>