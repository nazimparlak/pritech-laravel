# Mini Issue Tracker

A modern, fast, and responsive Mini Issue Tracker application built with **Laravel** and **Tailwind CSS**. Designed for small teams to seamlessly manage projects, issues, tags, and comments with interactive, page-reload-free AJAX workflows.

---

## 🚀 Features Implemented

### Core Requirements
* **Project Management (CRUD):** List, create, edit, and cascade-delete projects. Features an optimized dashboard displaying total issue counts and project status.
* **Issue Tracking (CRUD):** Complete task lifecycle management with priority states (`low`, `medium`, `high`) and active statuses (`open`, `in_progress`, `closed`).
* **Asynchronous Tagging (AJAX):** Attach and detach custom-colored tags to any issue directly via interactive inline controls without full page reloads.
* **Live Commenting (AJAX):** Post and fetch comments asynchronously. Newly added comments instantly prepend to the layout DOM.
* **Strict Security & UX:** Built-in server-side protection using custom **Laravel Form Requests**. Form validation failures natively render clear, inline visual warnings.

### Performance & Clean Code
* **Database Schema Optimization:** Implemented strict relational boundaries (`foreignId` constraints) along with a dedicated alteration migration to introduce flexible project scheduling (`start_date`, `deadline`).
* **N+1 Query Prevention:** Leveraged Eloquent's eager loading (`with(['issues.tags', 'project'])` and `withCount()`) to minimize database roundtrips.
* **Seeding & Factories:** Ready-to-test setup driven by structured data factories mapping complete inter-table node relationships.

### ⚡ Bonus Section Completed
* **Debounce-Optimized Text Search:** Implemented a real-time, asynchronous wildcard query handler on the Issues directory. Integrated a lightweight **300ms JavaScript debounce hook** to seamlessly parse string filters across titles and descriptions without bottlenecking application performance.

---

## 🛠️ Tech Stack

* **Backend:** Laravel 11 (PHP)
* **Frontend:** Blade Templates, Vanilla JavaScript (Fetch API)
* **Styling:** Tailwind CSS (via CDN for simplicity)
* **Database:** SQLite (Default for easy setup) / MySQL

---

## ⚙️ Installation & Setup Guide

Follow these steps to get the application up and running locally:

### 1. Clone the Repository
```bash
git clone <your-repository-url>
cd mini-issue-tracker
```

### 2. Install Dependencies
Make sure you have PHP and Composer installed on your machine.
```bash
composer install
```

### 3. Environment Configuration
Copy the example environment file and generate a new application key.
```bash
cp .env.example .env
php artisan key:generate
```
*Note: The project is pre-configured to use `database.sqlite` in the `.env.example` file. If you prefer MySQL, update the `DB_CONNECTION` values in the `.env` file accordingly.*

### 4. Database Setup & Seeding
Create the database tables and populate them with dummy data (Projects, Issues, Tags, and Comments).
```bash
php artisan migrate:fresh --seed
```

### 5. Run the Application
Start the Laravel development server.
```bash
php artisan serve
```

You can now access the application by visiting `http://localhost:8000` in your web browser.

---

## 💡 Usage Highlights

1. **Dashboard:** Navigate to `/projects` to see the overview of active projects.
2. **Issue Detail View:** Click on any issue to view its details. From here, you can test the **AJAX Tag Toggle** by selecting a tag from the dropdown, and you can test the **Live Comments** by typing a message at the bottom.
3. **AJAX Search:** Navigate to the **Issues** tab (`/issues`) from the top navigation bar. Start typing in the search box; the list will instantly filter without refreshing the page!
