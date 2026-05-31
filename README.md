# Interactive KSA Discovery - https://capstone.alshammarii.me/

A full-stack interactive web platform for exploring Saudi Arabia's regions, landmarks, and cultural heritage. Built with PHP, MySQL, and vanilla JavaScript — featuring an admin dashboard with full CRUD operations, image galleries, real-time search and filtering, dark mode, and a fully responsive RTL (Right-to-Left) Arabic interface.

> **Project Deck:** For a visual overview of the system design, features, and screenshots, see the [Project Presentation (PowerPoint)](Presentation.pptx).
>
> **Project Report:** For detailed documentation, see the [Project Report (PDF)](Report.pdf).

## Screenshots

### Home Page
The landing page introduces Saudi Arabia with a hero section and feature cards highlighting the platform's purpose.

### Gallery with Search & Filter
Browse all regions with real-time Arabic text search and category filtering. Results count updates dynamically.

### Region Details
Each region page displays a hero image, description, historical facts, landmarks, activities, climate info, and a photo gallery.

### Admin Dashboard
Authenticated admins can add, edit, and delete regions through a clean management interface with confirmation dialogs.

## Features

| Feature | Description |
|---------|-------------|
| **Region Gallery** | Browse Saudi regions with card-based layout and category badges |
| **Real-time Search** | Instant Arabic text search with dynamic result counting |
| **Category Filtering** | Filter regions by category (historical, modern, natural, etc.) |
| **Detail Pages** | Rich region pages with facts, landmarks, activities, climate, and photo gallery |
| **Admin Dashboard** | Secure login with full CRUD — add, edit, delete regions |
| **Image Upload** | Upload main image + up to 3 gallery images per region |
| **Dark Mode** | Toggle between light/dark themes, persisted in localStorage |
| **Responsive Design** | Mobile-first layout that adapts from phone to desktop |
| **RTL Support** | Native Right-to-Left Arabic interface with Tajawal font |
| **Input Validation** | Client-side form validation with inline error messages |
| **Delete Confirmation** | Modal confirmation dialog to prevent accidental deletions |
| **Prepared Statements** | PDO with parameterized queries to prevent SQL injection |

## Architecture

```
Client (Browser)
      │
      ▼
┌──────────────┐     ┌──────────────┐     ┌──────────────┐
│  index.php   │     │  gallery.php │     │  details.php │
│  (Landing)   │     │  (Browse)    │     │  (Region)    │
└──────┬───────┘     └──────┬───────┘     └──────┬───────┘
       │                    │                    │
       └────────────┬───────┴────────────────────┘
                    ▼
           ┌──────────────┐
           │  config/db   │ ◄── PDO + MySQL
           └──────────────┘
                    ▲
       ┌────────────┴───────────────────────┐
       │                                    │
┌──────┴───────┐                    ┌───────┴──────┐
│    admin/    │                    │   uploads/   │
│  dashboard   │                    │   images/    │
│  add/update  │                    │              │
│  delete/auth │                    │              │
└──────────────┘                    └──────────────┘
```

## Tech Stack

- **Backend:** PHP 8+ with PDO (MySQL)
- **Frontend:** HTML5, CSS3 (custom properties, grid, flexbox), vanilla JavaScript
- **Database:** MySQL / MariaDB with utf8mb4 encoding
- **Typography:** Google Fonts (Tajawal — Arabic-optimized)
- **Server:** Apache (XAMPP / LAMP / any PHP-capable server)

## Project Structure

```
interactive-ksa-discovery/
├── index.php                 # Landing page
├── gallery.php               # Region gallery with search & filter
├── details.php               # Individual region detail page
├── about.php                 # About page
├── config/
│   └── db.php                # Database connection (env-based)
├── admin/
│   ├── login.php             # Admin authentication
│   ├── auth.php              # Session guard
│   ├── dashboard.php         # Content management table
│   ├── add.php               # Add new region
│   ├── update.php            # Edit existing region
│   ├── delete.php            # Delete region
│   └── logout.php            # End session
├── css/
│   └── style.css             # Complete stylesheet (light/dark, responsive)
├── js/
│   └── main.js               # Dark mode, search, validation, confirmations
├── uploads/
│   └── images/               # Region photos
├── database/
│   └── schema.sql            # Database schema
├── docs/
│   ├── CSC457_CourseProject.pptx          # Project presentation
│   └── CSC457_CourseProject_Report_v5.pdf # Project report
├── .env.example              # Environment variable template
└── README.md
```

## Quick Start

```bash
# Clone the repository
git clone https://github.com/Abdu114hf16/interactive-ksa-discovery.git

# Set up the database
mysql -u root < database/schema.sql

# Configure environment
cp .env.example .env
# Edit .env with your database credentials

# Serve with PHP built-in server (or place in XAMPP/htdocs)
php -S localhost:8000

# Open in browser
# http://localhost:8000
```

## Security

- SQL injection prevention via PDO prepared statements
- XSS protection with `htmlspecialchars()` on all user-displayed content
- Input validation on both client and server side
- Session-based admin authentication with access guards
- Database credentials loaded from environment variables

## License

MIT
