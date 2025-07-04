// frontend/js/auth.js
const API_BASE = 'http://localhost:8000/api';

// Handle Sign In
document.getElementById('signin-form')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const errorElement = document.getElementById('auth-error');
    const submitBtn = e.target.querySelector('button[type="submit"]');
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Signing In...';
    errorElement.textContent = '';
    
    try {
        const response = await fetch(`${API_BASE}/login`, {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                email,
                password,
                device_name: navigator.userAgent
            })
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Login failed. Please try again.');
        }

        // Store token and user data
        localStorage.setItem('auth_token', data.token);
        localStorage.setItem('user', JSON.stringify(data.user));
        
        // Verify storage before redirect
        if (localStorage.getItem('auth_token')) {
            window.location.href = '/todos.html'; // Absolute path
        } else {
            throw new Error('Authentication token not stored');
        }

    } catch (error) {
        console.error('Login error:', error);
        errorElement.textContent = error.message;
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Sign In';
    }
});

// Handle Sign Up
document.getElementById('signup-form')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        password: document.getElementById('password').value,
        password_confirmation: document.getElementById('confirm-password').value,
        device_name: navigator.userAgent
    };
    
    const errorElement = document.getElementById('auth-error');
    const successElement = document.getElementById('success-message');
    const submitBtn = e.target.querySelector('button[type="submit"]');
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Creating Account...';
    errorElement.textContent = '';
    successElement.textContent = '';

    try {
        const response = await fetch(`${API_BASE}/register`, {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Registration failed. Please try again.');
        }

        // Show success and redirect
        successElement.textContent = 'Account created successfully! Redirecting to login...';
        setTimeout(() => {
            window.location.href = '/signin.html';
        }, 2000);

    } catch (error) {
        console.error('Registration error:', error);
        errorElement.textContent = error.message;
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Create Account';
    }
});

// Handle Logout
document.getElementById('logout-btn')?.addEventListener('click', async () => {
    try {
        const response = await fetch(`${API_BASE}/logout`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                'Accept': 'application/json'
            }
        });

        if (response.ok) {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user');
            window.location.href = '/signin.html';
        }
    } catch (error) {
        console.error('Logout error:', error);
    }
});

// Protect todo page
if (window.location.pathname.endsWith('todos.html')) {
    document.addEventListener('DOMContentLoaded', () => {
        if (!localStorage.getItem('auth_token')) {
            window.location.href = '/signin.html';
        }
    });
}