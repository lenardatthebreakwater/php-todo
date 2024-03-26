function main() {
	let allTodo = document.querySelectorAll("li")
	for (let i = 0; i < allTodo.length; i++) {
		if (localStorage.getItem(allTodo[i].value) !== null) {
			allTodo[i].classList.add("toBeDeleted")
			allTodo[i].classList.add("dark-grayish-blue-font")
			allTodo[i].childNodes[0].classList.add("checked")
		}
		allTodo[i].addEventListener("click", toggleTodoFromStorage)
	}

	let showActiveBtn = document.querySelector("#showActiveBtn")
	showActiveBtn.addEventListener("click", () => {
		let ul = document.querySelector("ul")
		ul.innerHTML = ""

		allTodo.forEach((li) => {
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
		this.classList.add("toBeDeleted")
		this.classList.add("dark-grayish-blue-font")
		this.childNodes[0].classList.add("checked")
		localStorage.setItem(todoID, todoItem)
		return
	}

	localStorage.removeItem(this.value)
	this.classList.remove("toBeDeleted")
	this.classList.remove("dark-grayish-blue-font")
	this.childNodes[0].classList.remove("checked")
}

function showCompleted() {
	let ul = document.querySelector("ul")
	ul.innerHTML = ""

	Object.keys(localStorage).forEach((key) => {
		let li = document.createElement("li")
		li.setAttribute("value", `${key}`)
		li.classList.add("toBeDeleted")
		li.classList.add("dark-grayish-blue-font")
		li.classList.add("very-dark-desaturated-blue-bg")
		li.addEventListener("click", toggleTodoFromStorage)

		let div = document.createElement("div")
		div.classList.add("small-circle")
		div.classList.add("checked")

		let img = document.createElement("img")
		img.setAttribute("src", "images/icon-check.svg")
		img.setAttribute("alt", "A Check")

		div.append(img)
		li.append(div)
		li.append(localStorage.getItem(key))
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
	let todoListFooter = document.querySelector("#todoListFooter")
	let ul = document.querySelector("ul")
	ul.innerHTML = ""

	if (Object.keys(responseBody).length === 0) {
		todoListFooter.style.display = "none"
	}

	Object.keys(responseBody).forEach((key) => {
		let li = document.createElement("li")
		li.setAttribute("value", `${key}`)
		li.classList.add("very-dark-desaturated-blue-bg")
		li.addEventListener("click", toggleTodoFromStorage)

		let div = document.createElement("div")
		div.classList.add("small-circle")

		let img = document.createElement("img")
		img.setAttribute("src", "images/icon-check.svg")
		img.setAttribute("alt", "A Check")

		div.append(img)
		li.append(div)
		li.append(responseBody[key])
		ul.append(li)
	})

	location.reload()
}

main()