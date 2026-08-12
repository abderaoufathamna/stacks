# 📚 Stacks — Library Management System

Stacks is a full library management system built from scratch with Laravel. It handles the complete lifecycle of a small-to-medium library: cataloguing books with cover art, organizing them by author and category, running a borrow-and-return workflow with due dates and limits, and giving admins the tools to manage the whole collection and its members — all wrapped in a custom-designed interface with no CSS framework and no JavaScript build step.

This README explains what the project does, how it's put together, and how to run it yourself.

---

## Table of Contents

- [What this project actually does](#what-this-project-actually-does)
- [Who can do what (roles)](#who-can-do-what-roles)
- [A walkthrough of the app](#a-walkthrough-of-the-app)
- [Database design](#database-design)
- [Design system](#design-system)
- [Tech stack](#tech-stack)
- [Getting started](#getting-started)
- [Demo accounts](#demo-accounts)
- [Project structure](#project-structure)
- [Ideas for extending this project](#ideas-for-extending-this-project)
- [License](#license)

---

## What this project actually does

Most "library management" tutorials stop at a CRUD list of books. Stacks goes further and models the actual _process_ a library runs:

- A **catalogue** of books, each linked to one author and one category, with a defined number of copies.
- A **borrowing system** where a logged-in member can check out an available book for a 14-day loan. The system automatically decrements the available copy count, and increments it again when the book is returned.
- A **per-member borrow limit** — members can only have a small number of books checked out at once (configurable), which is enforced both in the borrowing logic and reflected visually on their dashboard as a "slots used" indicator.
- **Overdue tracking** — any active loan past its due date is automatically flagged as overdue, both for the member (on their dashboard) and the admin (in the stats and recent activity feed).
- **Role separation** — the exact same book catalogue looks different depending on who's viewing it: members see a "Borrow" button, admins see "Edit" and "Delete" as well.

In short: it's not just a books table with a form — it's the actual circulation logic a library depends on.

---

## Who can do what (roles)

Every account has a role: `admin` or `user` (member). The role changes what's visible and what's reachable — this isn't just hidden buttons, the routes themselves are protected server-side.

**Members can:**

- Browse the catalogue, filter by category, sort by title or newest, and search instantly as they type
- Borrow an available book (up to the configured limit)
- See their current loans, due dates, and days remaining on their dashboard
- Return a book directly from the dashboard or their borrowing history
- Edit their name, email, and profile picture, and change their password

**Admins can do everything a member can, plus:**

- Add, edit, and delete books — including uploading/replacing cover images
- Manage the list of authors and categories
- View and manage every registered user — promote to admin, demote to member, or delete an account (with safeguards so an admin can't accidentally lock themselves out)
- See a live stats dashboard: total books, total copies across all titles, how many books are currently checked out, how many are overdue, and a feed of the 5 most recent borrowing events

---

## A walkthrough of the app

**Landing page** — a marketing-style homepage (separate from the logged-in app) introducing the system, its features, and how the borrow/return flow works, ending in a call to register or sign in.

**Auth** — a simple, branded register/login flow. Already-logged-in users are redirected away from these pages automatically instead of being shown a login form they don't need.

**Dashboard** — this is role-aware and shows two completely different views:

- _Admin dashboard:_ stat cards with animated counters, plus a feed of recent borrowing activity across all members.
- _Member dashboard:_ a "Currently Reading" list of their active loans with cover art and due dates, a visual borrow-slot indicator, and a "Discover" section suggesting newly added books that are currently available.

**Books page** — a card-grid catalogue (not a plain table) with a sidebar for filtering by category and sorting, plus an instant client-side search box that filters the visible cards as you type without reloading the page. Admin-only controls (Edit/Delete/Add) are hidden entirely for members, not just disabled.

**My Borrowings** — a full paginated history of everything a member has ever borrowed, current and past, with status badges (Borrowed / Returned / Overdue).

**Authors / Categories** — simple admin-only management pages for the two things every book is linked to.

**Users** — an admin-only table of every registered account, with one-click role toggling and account deletion.

**Profile** — every user, regardless of role, can update their personal info, upload a profile picture, and change their password from one page.

---

## Database design

Five tables drive the whole system:

```
users        — id, name, email, password, role (user|admin), avatar
authors      — id, name
categories   — id, name
books        — id, title, author_id, category_id, total_copies, available_copies, cover_image
borrowings   — id, book_id, user_id, borrowed_at, due_date, returned_at
```

**Relationships:**

```
Author    hasMany    Book
Category  hasMany    Book
Book      belongsTo  Author
Book      belongsTo  Category
Book      hasMany    Borrowing
Borrowing belongsTo  Book
Borrowing belongsTo  User
```

Conceptually, `borrowings` is the join table between `users` and `books` — every checkout, whether active or completed, is one row. This is what makes it possible to compute "currently borrowed," "overdue," and "borrowing history" all from the same table just by filtering on `returned_at` and `due_date`.

There's deliberately **no separate `members` table** — a registered user _is_ the member. This keeps the model simple: one account, one role, one borrowing history.

`available_copies` is a maintained counter rather than something calculated on the fly — it's decremented when a book is borrowed and incremented when it's returned, which keeps catalogue browsing fast without needing to count active loans on every page load.

---

## Design system

The interface follows a custom design language — no Bootstrap, no Tailwind, no component library. Everything is hand-written CSS and vanilla JavaScript, loaded directly from `public/`, with zero build step (no npm, no Vite).

The visual identity is built around the idea of a **physical library card catalog**: cards throughout the app (book cards, stat cards, the login form) have a small punched-hole notch at the top, echoing the index cards a librarian would once have flipped through by hand.

- **Typography:** [Fraunces](https://fonts.google.com/specimen/Fraunces) for headings (a serif with real character), [Inter](https://fonts.google.com/specimen/Inter) for body text, [IBM Plex Mono](https://fonts.google.com/specimen/IBM+Plex+Mono) for small labels and call-number-style tags
- **Palette:** layered warm browns — espresso, coffee, walnut, camel — on a parchment background, with a muted sage green and rust red standing in for the usual "success/danger" greens and reds
- **Two stylesheets:** `landing.css` for the public marketing page, `app.css` for everything behind login — both share the same variables and fonts, so the identity is consistent even though the layouts differ

---

## Tech stack

| Layer         | Choice                      | Why                                                                  |
| ------------- | --------------------------- | -------------------------------------------------------------------- |
| Backend       | Laravel (PHP)               | Routing, Eloquent ORM, migrations, validation                        |
| Views         | Blade                       | Server-rendered, no separate frontend build                          |
| Styling       | Hand-written CSS            | Full control over the design, no framework defaults to fight against |
| Interactivity | Vanilla JavaScript          | No npm/Vite required — just `<script>` tags                          |
| Database      | MySQL                       |                                                                      |
| File storage  | Laravel's local public disk | Book covers and avatars, served via `storage:link`                   |

---

## Getting started

### Requirements

- PHP 8.2+
- Composer
- MySQL
- No Node.js required

### Installation

```bash
git clone <your-repo-url>
cd stacks

composer install

cp .env.example .env
php artisan key:generate
```

Set your database credentials in `.env`:

```
DB_DATABASE=stacks
DB_USERNAME=root
DB_PASSWORD=
```

Then:

```bash
php artisan migrate --seed   # creates tables and fills them with demo data
php artisan storage:link     # required so uploaded covers/avatars are visible
php artisan serve
```

Visit **http://127.0.0.1:8000**.

---

## Demo accounts

Seeding creates ready-to-use accounts for both roles so you can explore the whole app immediately:

| Role   | Email               | Password   |
| ------ | ------------------- | ---------- |
| Admin  | `admin@stacks.test` | `password` |
| Member | `layla@stacks.test` | `password` |
| Member | `omar@stacks.test`  | `password` |
| Member | `sara@stacks.test`  | `password` |

The seeder also pre-populates a handful of authors, categories, books, and a mix of active/overdue/returned borrowings — so the dashboards and stats aren't showing empty states on first run.

> ⚠️ These are development-only credentials. Remove or change them before deploying anywhere public.

---

## Project structure

```
app/Http/Controllers/
    AuthController.php        — register / login / logout
    BookController.php        — book CRUD, cover upload, filtering & sorting
    BorrowingController.php   — borrow / return logic, borrow limit
    AuthorController.php      — author CRUD
    CategoryController.php    — category CRUD
    UserController.php        — admin user management
    DashboardController.php   — builds admin stats & member dashboard data
    ProfileController.php     — profile info, avatar, password

app/Models/
    User.php, Book.php, Author.php, Category.php, Borrowing.php

resources/views/
    welcome.blade.php         — landing page
    layouts/app.blade.php     — shared navbar/footer for the logged-in app
    auth/, books/, authors/, categories/, borrowings/, users/, profile/
    pagination/stacks.blade.php — custom-styled pagination

public/css/  — landing.css, app.css
public/js/   — landing.js, app.js

database/migrations/  — schema, including role/avatar/cover_image additions
database/seeders/      — demo data generator
```

---

## Ideas for extending this project

Things that would build naturally on top of what's here:

- Book reservations for titles that are fully checked out
- A "purchase" option alongside borrowing
- Multi-language support (Arabic/English), including RTL layout switching
- Ratings and written reviews on books
- Email notifications as a due date approaches
- Exportable reports (CSV/PDF) for admins

---

## License

Released under the [MIT License](LICENSE) — free to use, fork, or build on for learning or your own projects.
