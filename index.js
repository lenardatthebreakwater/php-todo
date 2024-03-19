function main() {
	let allTodo = document.querySelectorAll("li")
	for (let i = 0; i < allTodo.length; i++) {
		allTodo[i].addEventListener("click", addTodoToStorage)
	}

	let deleteTodosBtn = document.querySelector("#deleteTodosBtn")
	deleteTodosBtn.addEventListener("click", deleteTodos)
}

function addTodoToStorage() {
	console.log(this)
	let todoID = this.value
	let todoItem = this.innerText
	this.classList.add("toBeDeleted")
	localStorage.setItem(todoID, todoItem)
}

function deleteTodos() {
	todosToBeDeleted = getTodosFromStorage()

	fetch("/deletetodo.php", {
		method: "POST",
		headers: { "Content-Type": "application/json", },
		body: JSON.stringify(todosToBeDeleted),
	})
	.then((response) => response.json())
	.then((responseBody) => (displayRemainingTodos(responseBody)))
}

function getTodosFromStorage() {
	let todosToBeDeleted = []

	Object.keys(localStorage).forEach((key) => {
		let todoID = parseInt(key)
   		let todoItem = localStorage.getItem(key)
   		let todo = {
   			todoItem: todoItem,
   			todoID: todoID
   		}
   		todosToBeDeleted.push(todo)
   	})

	localStorage.clear()
	return todosToBeDeleted
}

function displayRemainingTodos(responseBody) {
	let ul = document.querySelector("ul")
	ul.innerHTML = ""

	responseBody.forEach((todo) => {
		ul.innerHTML += `<li>${todo}</li>`
	})
}

main()