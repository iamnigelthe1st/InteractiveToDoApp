Here's a modern, visually enhanced version of your README with icons and improved formatting:

# 🚀 Modern To-Do App

![Todo App Screenshot](https://prnt.sc/BMAEoYBMDJpp)  
*A sleek, productive task management experience*

## 🌟 Overview

The Modern To-Do App is a full-stack web application that combines the power of **Vue.js** (frontend) and **Laravel** (backend) to deliver a seamless task management experience. With its intuitive interface and robust features, staying organized has never been easier!

[![Vue.js](https://img.shields.io/badge/Vue.js-4FC08D?style=for-the-badge&logo=vuedotjs&logoColor=white)](https://vuejs.org/)
[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)

## ✨ Key Features

| Feature | Description |
|---------|-------------|
| 🔐 **User Authentication** | Secure registration/login with JWT tokens |
| 📝 **Task Management** | Add, edit, delete, and complete tasks with ease |
| 🔍 **Smart Filtering** | Filter by: All/Active/Completed tasks |
| 🌈 **Themes** | Light/Dark mode support |
| 📱 **Responsive Design** | Works flawlessly on all devices |
| ⚡ **Instant Updates** | Real-time sync between frontend and backend |
| 🔄 **Data Persistence** | All tasks saved to secure database |

## 🛠️ Tech Stack

### Frontend
![Vue.js](https://img.shields.io/badge/Vue.js-3-4FC08D?logo=vuedotjs&logoColor=white)
![Pinia](https://img.shields.io/badge/Pinia-FFD02F?logo=pinia&logoColor=black)
![Axios](https://img.shields.io/badge/Axios-5A29E4?logo=axios&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?logo=tailwind-css&logoColor=white)

### Backend
![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20?logo=laravel&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-003B57?logo=sqlite&logoColor=white)
![JWT](https://img.shields.io/badge/JWT-Auth-000000?logo=json-web-tokens&logoColor=white)

## 🚀 Quick Start

### Prerequisites
- Node.js v16+
- PHP 8.1+
- Composer
- SQLite

### Installation

```bash
# 1. Clone repository
git clone https://github.com/your-username/modern-todo-app.git
cd modern-todo-app

# 2. Backend setup
cd backend
composer install
cp .env.example .env
touch database/database.sqlite
php artisan key:generate
php artisan jwt:secret
php artisan migrate --seed

# 3. Frontend setup
cd ../frontend
npm install
cp .env.example .env

# 4. Run development servers
# In backend directory:
php artisan serve

# In frontend directory (new terminal):
npm run dev
```

Access the app at: [http://localhost:3000](http://localhost:3000)

## 📸 Screenshots

| Login Screen | Dashboard |
|--------------|-----------|
| ![Login](https://prnt.sc/_R0bJuXEVVNl) | ![SignUp](https://prnt.sc/rLvG8c3FAHa0) |

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📬 Contact

Project Maintainer: [Keegan Kinyanjui](mailto:keegan@turelabs.com)  
[![Twitter](https://img.shields.io/badge/Twitter-1DA1F2?logo=twitter&logoColor=white)](https://twitter.com/iamnigelthe1st)
[![GitHub](https://img.shields.io/badge/GitHub-181717?logo=github&logoColor=white)](https://github.com/iamnigelthe1st)

---

Made with ❤️ and ☕ by [Keegan Kinyanjui]  

![Todo App Demo](https://media.giphy.com/media/your-demo-gif.gif)  
*See it in action!*
