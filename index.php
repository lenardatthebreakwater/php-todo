<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Todo Application in PHP</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="very-dark-blue-bg">
	<header class="hero">
		<h1 class="big-text">TODO</h1>
	</header>
	<main>
		<form method="POST" action="/addtodo.php">
			<input class="very-dark-desaturated-blue-bg small-rectangle-container" type="text" name="todo_item" id="todo_item" placeholder="Create a new todo..." autofocus required>
			<button type="submit" hidden>Add Todo Item</button>
		</form>
		
		<?php
		$conn = new PDO("sqlite:file:todo.db?mode=rwc");

		$conn->exec("CREATE TABLE IF NOT EXISTS todo(todo_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, todo_item TEXT NOT NULL)");
		
		$stmt = $conn->prepare("SELECT * FROM todo");
		$stmt->execute();
		$rows = $stmt->fetchall();

		echo "<ul>";
		for ($i = 0; $i < count($rows); $i++) {
			echo "<li value={$rows[$i]["todo_id"]} class='very-dark-desaturated-blue-bg small-rectangle-container'>{$rows[$i]["todo_item"]}</li>";
		}
		echo "</ul>";

		$conn = null;
		$stmt = null;
		?>

		<div class="very-dark-desaturated-blue-bg small-rectangle-container">
			<button id="showActiveBtn" class="very-dark-desaturated-blue-bg">Active</button>
			<button id="showCompletedBtn" class="very-dark-desaturated-blue-bg">Completed</button>
			<button id="deleteTodosBtn" class="very-dark-desaturated-blue-bg">Clear Completed</button>
		</div>
	</main>
	<script src="index.js"></script>
</body>
</html>