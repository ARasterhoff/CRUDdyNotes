# 📝 CRUDdyNotes

**CRUDdyNotes** is a simple, brutalist-styled PHP web app for taking and managing personal notes.  
It uses full **CRUD operations** (Create, Read, Update, Delete) with user login authentication, so each user can privately manage their own notes.

Built to be clean, fast, and extremely functional — with no fluff.

---

## 🚀 Features

- 🧾 Register/Login system with secure password hashing (bcrypt)
- 🔐 Session-based authentication
- ✏️ Create, edit, and delete your own notes only
- 👁️ Read all your personal notes in a minimalist UI
- 📁 Notes are stored in a MySQL database
- 💻 Brutalist UI using basic HTML/CSS (Courier New, hard lines, no JS)
- 🔒 Notes are **user-isolated** — no one sees anyone else's notes

---

## 🧱 Tech Stack

- PHP (vanilla)
- MySQL
- HTML/CSS (brutalist style)

---

## 🛠️ Setup

1. **Clone or download the project**
2. Import `cruddy_notes_schema.sql` into your MySQL database
3. Configure your database connection in `db.php`
    ```php
    $host = 'localhost';
    $user = 'your_db_user';
    $pass = 'your_db_password';
    $dbname = 'your_db_name';
    ```
4. Upload all files to your web host's `public_html/` (or use XAMPP's `htdocs/`)
5. Visit the site in your browser and register an account!

---

## 🧪 Local Development (XAMPP)

- Place files in `htdocs/cruddynotes/`
- Start Apache + MySQL in XAMPP
- Visit: [http://localhost/cruddynotes](http://localhost/cruddynotes)

---

## 🤘 Author

Made with ❤️ and Courier New  
By Alex Rasterhoff

---

## 📜 License

MIT — do whatever, just don’t blame me if it deletes your poetry.

