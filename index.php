<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Todo Application in PHP</title>
</head>
<body>

	<form method="POST" action="addtodo.php">
		<label for="todo_item">Todo</label>
		<input type="text" name="todo_item" id="todo_item" required>
		<button type="submit">Add Todo Item</button>
	</form>
	
	<?php

	$conn = new PDO("sqlite:file:todo.db?mode=rwc");
	
	$stmt = $conn->prepare("SELECT todo_item FROM todo");
	$stmt->execute();
	$rows = $stmt->fetchall();

	echo "<ul>";
	for ($i = 0; $i < count($rows); $i++) {
		echo "<li>{$rows[$i][0]}</li>";
	}
	echo "</ul>";

	$conn = null;
	$stmt = null;

	?>
</body>
</html>