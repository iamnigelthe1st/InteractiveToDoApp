// frontend/js/todos.js
const API_BASE = 'http://localhost:8000/api';
let todos = [];

document.addEventListener('DOMContentLoaded', () => {
    if (!localStorage.getItem('auth_token')) {
        window.location.href = '/signin.html';
        return;
    }

    loadTodos();
    setupEventListeners();
});

async function loadTodos() {
    try {
        const response = await fetch(`${API_BASE}/todos`, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) throw new Error('Failed to load todos');
        
        todos = await response.json();
        renderTodos();
    } catch (error) {
        console.error('Error:', error);
        alert('Session expired. Please login again.');
        window.location.href = '/signin.html';
    }
}

function renderTodos() {
    const todoList = document.getElementById('todo-list');
    todoList.innerHTML = '';

    if (todos.length === 0) {
        todoList.innerHTML = '<li class="list-group-item text-center text-muted">No todos found</li>';
        return;
    }

    todos.forEach(todo => {
        const li = document.createElement('li');
        li.className = `list-group-item ${todo.completed ? 'completed' : ''}`;
        li.dataset.id = todo.id;
        li.innerHTML = `
            <div class="d-flex align-items-center">
                <input type="checkbox" class="form-check-input me-3" ${todo.completed ? 'checked' : ''}>
                <span class="flex-grow-1">${todo.text}</span>
                <button class="btn btn-sm btn-danger delete-btn">Delete</button>
            </div>
        `;
        todoList.appendChild(li);
    });
}

function setupEventListeners() {
    document.getElementById('todo-form').addEventListener('submit', addTodo);
}

async function addTodo(e) {
    e.preventDefault();
    
    const textInput = document.getElementById('new-todo');
    const text = textInput.value.trim();
    
    if (!text) return;

    try {
        const response = await fetch(`${API_BASE}/todos`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ text })
        });

        if (!response.ok) throw new Error('Failed to add todo');
        
        textInput.value = '';
        loadTodos(); // Refresh the list
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to add todo. Please try again.');
    }
}