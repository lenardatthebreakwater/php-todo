function main() {
	let allTodo = document.querySelectorAll("li")
	for (let i = 0; i < allTodo.length; i++) {
		if (localStorage.getItem(allTodo[i].value) !== null) {
			allTodo[i].classList.add("toBeDeleted")
		}
		allTodo[i].addEventListener("click", toggleTodoFromStorage)
	}

	let showActiveBtn = document.querySelector("#showActiveBtn")
	showActiveBtn.addEventListener("click", () => {
		let ul = document.querySelector("ul")
		ul.innerHTML = ""

		allTodo.forEach((li) => {
			console.log(li)
			if (localStorage.getItem(li.value) === null) {
				ul.append(li)
			}
		})
	})

	let showCompletedBtn = document.querySelector("#showCompletedBtn")
	showCompletedBtn.addEventListener("click", showCompleted)

	let deleteTodosBtn = document.querySelector("#deleteTodosBtn")
	deleteTodosBtn.addEventListener("click", deleteTodos)
}

function toggleTodoFromStorage() {
	if (localStorage.getItem(this.value) === null) {
		let todoID = this.value
		let todoItem = this.innerText
		console.log(this)
		this.classList.add("toBeDeleted")
		localStorage.setItem(todoID, todoItem)
		return
	}

	localStorage.removeItem(this.value)
	this.classList.remove("toBeDeleted")
}

function showCompleted() {
	let ul = document.querySelector("ul")
	ul.innerHTML = ""

	Object.keys(localStorage).forEach((key) => {
		let li = document.createElement("li")
		li.setAttribute("value", `${key}`)
		li.append(localStorage.getItem(key))
		li.classList.add("toBeDeleted")
		li.addEventListener("click", toggleTodoFromStorage)
		ul.append(li)
	})
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

	console.log(responseBody)

	Object.keys(responseBody).forEach((key) => {
		let li = document.createElement("li")
		li.setAttribute("value", `${key}`)
		li.append(responseBody[key])
		li.addEventListener("click", toggleTodoFromStorage)
		ul.append(li)
	})
}

main()