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

		<form method="POST" action="/addtodo.php">
			<input class="very-dark-desaturated-blue-bg" type="text" name="todo_item" id="todo_item" placeholder="Create a new todo..." required>
			<button type="submit" hidden>Add Todo Item</button>
		</form>
	</header>
	<main>
		<?php
		$conn = new PDO("sqlite:file:todo.db?mode=rwc");

		$conn->exec("CREATE TABLE IF NOT EXISTS todo(todo_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, todo_item TEXT NOT NULL)");
		
		$stmt = $conn->prepare("SELECT * FROM todo");
		$stmt->execute();
		$rows = $stmt->fetchall();

		echo "<ul>";
		for ($i = 0; $i < count($rows); $i++) {
			echo "<li value={$rows[$i]["todo_id"]} class='very-dark-desaturated-blue-bg'>{$rows[$i]["todo_item"]}</li>";
		}
		echo "</ul>";

		$conn = null;
		$stmt = null;

		if (!empty($rows)) { 
		echo"<div class='very-dark-desaturated-blue-bg' id='todoListFooter'>
			<button id='showActiveBtn' class='very-dark-desaturated-blue-bg small-text dark-grayish-blue-font'>Active</button>
			<button id='showCompletedBtn' class='very-dark-desaturated-blue-bg small-text dark-grayish-blue-font'>Completed</button>
			<button id='deleteTodosBtn' class='very-dark-desaturated-blue-bg small-text dark-grayish-blue-font'>Clear Completed</button>
		</div>";
		}
		?>
	</main>
	<script src="index.js"></script>
</body>
</html>