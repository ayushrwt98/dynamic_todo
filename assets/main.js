const form = document.querySelector("#todo-form");
const list = document.querySelector("#todo-list");
function addTodo(e) {
  e.preventDefault();
  if (e.target.todo.value.trim() === "") {
    return;
  }
  const formData = new FormData(e.target);
  fetch("add.php", {
    method: "POST",
    body: formData,
  })
    .then(function (response) {
      return response.json();
    })
    .then(function (response) {
      if (response.status === 1) {
        list.innerHTML += `
        <li class="list-group-item d-flex justify-content-between align-items-center mt-3">
                    <div class="flex-1">${response.data.todo}</div>
                    <div>
                        <button class="btn btn-success" onclick="completeTodo(${response.data.id}, this)">Complete</button>
                        <button class="btn btn-danger" onclick="removeTodo(${response.data.id}, this)">Remove</button>
                    </div>
                </li>
        `;
      } else {
      }
    })
    .catch(function (err) {
      console.log(err);
    });
  e.target.todo.value = "";
}
if (form) {
  form.addEventListener("submit", addTodo);
}

function removeTodo(id, btn) {
  fetch("remove.php?id=" + id)
    .then(function (res) {
      return res.json();
    })
    .then(function (res) {
      if (res.status === 1) {
        btn.parentElement.parentElement.remove();
      } else {
        alert(res.message);
      }
    })
    .catch(function (err) { });
}

function completeTodo(id, btn) {
  fetch("complete.php?id=" + id)
    .then(function (res) {
      return res.json();
    })
    .then(function (res) {
      if (res.status === 1) {
        btn.className = "btn btn-secondary";
        btn.innerHTML = "Completed";
      } else {
        alert(res.message);
      }
    })
    .catch(function (err) { });
}

async function completeTodo(id, btn) {
  const response = await fetch("complete.php?id=" + id)
  const res = await response.json();
  if (res.status === 1) {
    btn.className = "btn btn-secondary";
    btn.innerHTML = "Completed";
  } else {
    alert(res.message);
  }
}

async function getTodos() {
  const userId = document.querySelector("#user_id").value;
  const response = await fetch("get_todos.php?user_id=" + userId)
  const res = await response.json();
  list.innerHTML = "";
  res.todos.forEach(function (item) {
    list.innerHTML += `
    <li class="list-group-item d-flex justify-content-between align-items-center mt-3">
      <div class="flex-1">${item.todo}</div>
      <div>
        <button class="btn btn-${item.completed === '1' ? 'secondary' : 'success'}" onclick="completeTodo(${item.id}, this)">${item.completed === "1" ? "Completed" : "Complete"}</button>
        <button class="btn btn-danger" onclick="removeTodo(${item.id}, this)">Remove</button>
      </div>
    </li>
        `;
  })
}

getTodos().then(function() {
  console.log("loaded")
}).catch(function (err) {
  console.log('cannot load')
  // console.log(err)
})