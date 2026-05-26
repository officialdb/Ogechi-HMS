<div align="center">
  <img src="public/storage/images/hero.jpg" alt="Ogechi Hospital" width="100%" style="border-radius: 12px;" onerror="this.style.display='none'">

  # 🏥 Ogechi Hospital Management System (HMS)

  <p align="center">
    <strong>A modern, premium, and highly optimized Hospital Management System built for Ogechi Hospital.</strong>
  </p>

  <p align="center">
    <a href="https://github.com/officialdb/Ogechi-HMS/actions/workflows/ftp-deploy.yml"><img src="https://github.com/officialdb/Ogechi-HMS/actions/workflows/ftp-deploy.yml/badge.svg?branch=main" alt="Deploy Status"></a>
    <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat&logo=laravel" alt="Laravel Version">
    <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php" alt="PHP Version">
    <img src="https://img.shields.io/badge/TailwindCSS-3.4-38B2AC?style=flat&logo=tailwind-css" alt="Tailwind CSS">
    <img src="https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=flat&logo=alpine.js" alt="Alpine.js">
  </p>
</div>

---

## 🌟 Overview

The **Ogechi HMS** is a comprehensive and secure web application designed to streamline the operations of Ogechi Hospital. It manages everything from patient registration and clinical records to billing, pharmacy, and laboratory reports—all wrapped in a beautiful, responsive, and intuitive user interface.

## ✨ Key Features

- **🧑‍⚕️ Patient Management:** Comprehensive registration, medical history tracking, emergency contacts, and next-of-kin records.
- **📅 Appointments & Scheduling:** Streamlined doctor appointments and consultation tracking.
- **🏥 Departments & Staff:** Manage hospital departments, assign doctors, and track staff availability.
- **💊 Pharmacy Module:** Inventory management for medicines and automated prescription handling.
- **🧪 Laboratory:** Integrated lab test requests, result tracking, and reporting.
- **💳 Billing & Invoicing:** Automated invoice generation, payment tracking, and financial reporting.
- **📊 Admin Dashboard:** Real-time KPIs, statistics, and modular settings management.
- **🌍 Frontend Website:** A public-facing CMS for blog posts, hospital information, and contact details.

## 🛠️ Technology Stack

- **Backend:** [Laravel 11](https://laravel.com/) (PHP 8.2+)
- **Frontend Core:** Blade Templates, [Tailwind CSS](https://tailwindcss.com/), [Alpine.js](https://alpinejs.dev/)
- **Build Tool:** [Vite](https://vitejs.dev/)
- **Database:** MySQL
- **Icons:** Heroicons

## 🚀 Deployment & CI/CD Workflow

This repository utilizes a modern, zero-downtime deployment strategy using **GitHub Actions**.

### Branches Strategy
- **`dev` Branch:** Used for all active development and staging.
- **`main` Branch:** The production branch. **Do not push directly to main.**

### How to Deploy
1. Push your code changes to the `dev` branch.
2. Open a **Pull Request (PR)** from `dev` to `main` on GitHub.
3. Once the PR is approved and **merged**, the `Deploy via FTP` GitHub Action will automatically trigger.
4. The workflow will compile all assets, optimize the backend, and securely sync only the modified files directly to the live cPanel server.

## 💻 Local Installation

To run this application on your local machine, follow these steps:

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL Database

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/officialdb/Ogechi-HMS.git
   cd Ogechi-HMS
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install & Compile Node Dependencies**
   ```bash
   npm install
   npm run dev
   ```

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Make sure to configure your `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in the `.env` file.*

5. **Run Migrations & Seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Serve the Application**
   ```bash
   php artisan serve
   ```
   *Visit `http://localhost:8000` in your browser.*

---

<div align="center">
  <p>Built with ❤️ for Ogechi Hospital</p>
</div>
