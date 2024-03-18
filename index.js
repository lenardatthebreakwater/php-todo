let allTodo = document.querySelectorAll("li")

for (let i = 0; i < allTodo.length; i++) {
	allTodo[i].addEventListener("click", () => {
		let todoID = allTodo[i].value
		let todoItem = allTodo[i].innerText
		allTodo[i].classList.add("toBeDeleted")
		localStorage.setItem(todoID, todoItem)
	})
}

function getTodosFromStorage() {
	let allTodoToBeDeleted = []

	Object.keys(localStorage).forEach((key) => {
		let todoID = parseInt(key)
   		let todoItem = localStorage.getItem(key)
   		let todo = {
   			todoItem: todoItem,
   			todoID: todoID
   		}
   		allTodoToBeDeleted.push(todo)
   	})

	localStorage.clear()
	return allTodoToBeDeleted
}