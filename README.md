# Mini Issue Tracker

A modern, fast, and responsive Mini Issue Tracker application built with **Laravel** and **Tailwind CSS**. Designed for small teams to seamlessly manage projects, issues, tags, and comments with interactive, page-reload-free AJAX workflows.

---

## 🚀 Features Implemented

### Core Requirements
* **Project Management (CRUD):** List, create, edit, and cascade-delete projects. Features an optimized dashboard displaying total issue counts and project status.
* **Issue Tracking (CRUD):** Complete task lifecycle management with priority states (`low`, `medium`, `high`) and active statuses (`open`, `in_progress`, `closed`).
* **Asynchronous Tagging (AJAX):** Attach and detach custom-colored tags to any issue directly via interactive inline controls without full page reloads.
* **Live Commenting (AJAX):** Post and fetch comments asynchronously. Newly added comments instantly prepend to the layout DOM, clearing validation inputs dynamically.
* **Strict Security & UX:** Built-in server-side protection using custom **Laravel Form Requests**. Form validation failures natively render clear, inline visual warnings rather than browser alert boxes.

### Performance & Clean Code
* **Database Schema Optimization:** Implemented strict relational boundaries (`foreignId` constraints) along with a dedicated alteration migration to introduce flexible project scheduling (`start_date`, `deadline`).
* **N+1 Query Prevention:** Leveraged Eloquent's eager loading (`with(['issues.tags'])` and `withCount()`) to minimize database roundtrips, maximizing resource delivery speed.
* **Seeding & Factories:** Ready-to-test setup driven by structured data factories mapping complete inter-table node relationships.

### ⚡ Bonus Section Completed
* **Debounce-Optimized Text Search:** Implemented a real-time, asynchronous wildcard query handler on the Issues directory. Integrated a lightweight **300ms JavaScript debounce hook** to seamlessly parse string filters across titles and descriptions without bottlenecking application performance.

---

## 🛠️ Tech Stack

* **Backend:** Laravel (v13 preferred architecture)
* **Frontend:** Blade Templates, Vanilla JavaScript (Fetch API)
* **Styling:** Tailwind CSS (Modern Dark Mode Framework)
* **Database:** MySQL / MariaDB (Supports SQLite)

---

## ⚙️ Installation & Setup Guide

Follow these sequential steps to get the application up and running locally:

### 1. Clone the Repository
```bash
git clone [https://github.com/nazimparlak/spritech-laravel.git](https://github.com/nazimparlak/spritech-laravel.git)
cd pritech-laravel
