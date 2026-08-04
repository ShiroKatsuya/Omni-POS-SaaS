# KasirPro Cloud — Multi-Tenant POS & ERP SaaS Platform

[![Next.js](https://img.shields.io/badge/Next.js-16.2-black?style=flat-square&logo=next.js)](https://nextjs.org/)
[![NestJS](https://img.shields.io/badge/NestJS-11.0-e0234e?style=flat-square&logo=nestjs)](https://nestjs.com/)
[![TypeScript](https://img.shields.io/badge/TypeScript-5.7-3178c6?style=flat-square&logo=typescript)](https://www.typescriptlang.org/)
[![Prisma](https://img.shields.io/badge/Prisma-6.19-2d3748?style=flat-square&logo=prisma)](https://www.prisma.io/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.0-38bdf8?style=flat-square&logo=tailwindcss)](https://tailwindcss.com/)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15-4169e1?style=flat-square&logo=postgresql)](https://www.postgresql.org/)

**KasirPro Cloud** is an enterprise-grade, multi-tenant Point of Sale (POS) and Enterprise Resource Planning (ERP) SaaS platform designed for retail stores, restaurants, service businesses, and franchises. Built with a modern micro-monorepo setup using Next.js 16 (Turbopack) and NestJS 11, it provides an intuitive checkout terminal, automated WhatsApp receipts, comprehensive inventory control, double-entry financial accounting, and multi-store management.

---

## 🌟 Key Features

### 🛒 Point of Sale (POS) Terminal
* **Fast Cashier Interface**: Responsive checkout interface built for rapid barcode scanning and item searching.
* **Flexible Payments**: Support for Cash, QRIS, Bank Transfers, E-Wallets, and split payments across multiple methods.
* **Dynamic Discounts & Taxes**: Apply percentage or fixed-amount discounts per item or transaction-wide.
* **Thermal Receipt Printing**: Customizable receipt templates tailored per tenant with browser print formatting.

### 📲 Automated WhatsApp Notification Engine
* **Direct Customer Receipts**: Auto-generate formatted receipts and deliver them straight to customers via WhatsApp upon checkout or refund.
* **QR-Based Authentication**: Seamless WhatsApp Web pairing powered by `@whiskeysockets/baileys` directly from the dashboard.
* **Message Delivery Queue & Retries**: Built-in retry handling and delivery log tracking for all automated messages.

### 📦 Inventory & Supply Chain Management
* **Stock Tracking & Alerts**: Automated stock adjustments (Stock In, Stock Out, Adjustments) with minimum stock alert thresholds.
* **Purchase Orders (PO)**: Generate purchase orders, manage supplier catalogs, and track partial/full inventory receipts.
* **Product Catalog**: Multi-category mapping, SKU and barcode management, purchase/selling price calculation.

### 📊 Financial Accounting & Ledger
* **Double-Entry Bookkeeping**: Automatic generation of journal entries (`JournalEntry`, `JournalEntryLine`) for transactions, refunds, expenses, and PO receipts.
* **Expense Management**: Categorize operational expenses (Rent, Utilities, Salaries, Supplies) and link them to user activities.
* **General Ledger Overview**: Monitor real-time account balances (Cash, Inventory, Accounts Payable, Revenue, COGS).

### 👥 CRM & Role-Based Access Control (RBAC)
* **Customer Directory**: Track customer transaction history and contact details.
* **Granular Permissions**: Role-based control supporting `SUPER_ADMIN` (Platform Manager), `OWNER` (Store Manager), and `CASHIER` (Terminal Operator).

### ⚙️ Multi-Tenant SaaS & Super Admin
* **Tenant Isolation**: Secure data partitioning per tenant with custom slugs, business details, currency settings, and subscription plans (`BASIC`, `GROWTH`, `ENTERPRISE`).
* **Feature Toggles**: Admin system for enabling or disabling exclusive platform features (`TenantFeature`) dynamically per business tenant.

---

## 🏗️ System Architecture

```mermaid
graph TD
    subgraph CL["Client Layer"]
        A["Next.js 16 Web App / Cashier Terminal"]
        B["Super Admin & Owner Dashboard"]
    end

    subgraph API["API & Backend Services NestJS 11"]
        C["Auth Module JWT / Passport"]
        D["POS & Transaction Engine"]
        E["Inventory & PO Service"]
        F["Accounting & Ledger Service"]
        G["WhatsApp Baileys Gateway"]
    end

    subgraph SM["Storage & Messaging"]
        H[("PostgreSQL Database")]
        I[("Redis Cache")]
        J["WhatsApp Web API"]
    end

    CL -->|REST API / WebSockets| C
    CL -->|REST API| D
    CL -->|REST API| E
    CL -->|REST API| F
    API -->|Prisma ORM| H
    API -->|Pub/Sub & Cache| I
    G -->|Direct Connection| J
```

---

## 💻 Technology Stack

| Layer | Technology | Key Libraries / Frameworks |
| :--- | :--- | :--- |
| **Frontend** | Next.js 16 (App Router, Turbopack), React 19 | Tailwind CSS v4, `@tanstack/react-query`, `react-hook-form`, `zod`, `lucide-react`, `socket.io-client` |
| **Backend** | NestJS 11, Node.js v20+ | Prisma ORM 6, `@whiskeysockets/baileys`, Socket.IO, Passport JWT, Pino Logger, `class-validator` |
| **Database** | PostgreSQL 15+ | Neon Cloud Serverless Postgres / Local Docker Postgres |
| **Caching** | Redis 7 | Docker Redis Container |
| **DevOps** | Docker, Docker Compose | Vercel (Frontend), Node.js Runtime (Backend) |

---

## 📁 Project Structure

```text
website-kasir/
├── src/                          # Next.js Frontend Application
│   ├── app/                      # Next.js App Router
│   │   ├── dashboard/            # Core Platform Dashboards
│   │   │   ├── pos/              # Point of Sale Checkout Screen
│   │   │   ├── products/         # Product Catalog Management
│   │   │   ├── categories/       # Category Management
│   │   │   ├── inventory/        # Stock Logs & PO Tracking
│   │   │   ├── transactions/     # Sales History & Receipts
│   │   │   ├── customers/        # Customer CRM
│   │   │   ├── suppliers/        # Supplier Directory
│   │   │   ├── reports/          # Analytics & Business Intelligence
│   │   │   ├── accounting/       # Expenses & General Ledger
│   │   │   ├── exclusive-features/ # Admin Feature Toggles
│   │   │   ├── admin/            # Super Admin Tenant Management
│   │   │   └── settings/         # Store & WhatsApp Bot Configuration
│   │   ├── layout.tsx            # Global Layout Structure
│   │   └── page.tsx              # Landing Page / Portal Entry
│   └── components/               # UI Components (shadcn/ui, Custom Widgets)
│
├── backend/                      # NestJS Backend API Service
│   ├── src/
│   │   ├── auth/                 # Authentication & JWT Guards
│   │   ├── tenant/               # Multi-Tenant & Subscription Services
│   │   ├── user/                 # User Accounts & RBAC
│   │   ├── product/              # Product API
│   │   ├── transaction/          # POS Checkout & Receipt Generator
│   │   ├── inventory/            # Inventory Adjustments & Stock Logs
│   │   ├── purchase-order/       # PO Workflows
│   │   ├── accounting/           # Expenses & Journal Ledger Engine
│   │   ├── whatsapp/             # Baileys QR Code Engine & Message Queue
│   │   ├── report/               # Analytics Aggregation Engine
│   │   └── main.ts               # NestJS Entry Point
│   ├── prisma/
│   │   ├── schema.prisma         # Database Models & Relationships
│   │   └── seed.ts               # Initial Seed Data
│   └── package.json
│
├── docker-compose.yml            # Local Infrastructure (PostgreSQL & Redis)
├── package.json                  # Root Frontend Package Config
└── README.md
```

---

## 🛠️ Getting Started

### Prerequisites

Ensure you have the following installed on your system:
* **Node.js** v20.x or higher
* **npm** (v9+) or **yarn** / **pnpm**
* **Docker Desktop** (optional, for local PostgreSQL & Redis)

---

### 1. Repository Setup

Clone the repository and install dependencies for both frontend and backend:

```bash
# Clone the repository
git clone https://github.com/your-username/website-kasir.git
cd website-kasir

# Install Frontend Dependencies (Root)
npm install

# Install Backend Dependencies
cd backend
npm install
cd ..
```

---

### 2. Environment Configuration

#### Backend Environment (`backend/.env`)

Create a `.env` file inside the `backend/` directory:

```env
DATABASE_URL="postgresql://pos_admin:pos_password@localhost:5433/pos_saas?schema=public"
JWT_SECRET="your-super-secret-jwt-key-change-in-production"
FRONTEND_URL="http://localhost:3001"
LANDING_PAGE_URL="http://localhost:8000"
PORT=3000
```

#### Frontend Environment (`.env.local`)

Create a `.env.local` file in the root directory:

```env
NEXT_PUBLIC_API_URL="http://localhost:3000"
DATABASE_URL="postgresql://pos_admin:pos_password@localhost:5433/pos_saas?schema=public"
```

---

### 3. Database Initialization

Start local PostgreSQL and Redis using Docker Compose:

```bash
# Start PostgreSQL (port 5433) and Redis (port 6379)
docker-compose up -d

# Run Database Schema Push & Seed Data (from backend directory)
cd backend
npm run db:push
npm run db:seed
cd ..
```

---

### 4. Running Development Servers

Start both the backend NestJS service and frontend Next.js application:

```bash
# Terminal 1: Start Backend API (Port 3000)
cd backend
npm run start:dev

# Terminal 2: Start Frontend App (Port 3001)
npm run dev
```

Once running, access the services:
* **Frontend Web Application**: [http://localhost:3001](http://localhost:3001)
* **Backend API Base**: [http://localhost:3000](http://localhost:3000)
* **API Documentation (Swagger)**: [http://localhost:3000/api](http://localhost:3000/api)

---

## 📜 Available Scripts

### Root Project (Frontend)

| Command | Description |
| :--- | :--- |
| `npm run dev` | Starts Next.js development server on port 3001 with Turbopack. |
| `npm run build` | Compiles the production build for the frontend application. |
| `npm run start` | Launches the built production Next.js server. |
| `npm run lint` | Runs ESLint checks across frontend source code. |

### Backend Service (`/backend`)

| Command | Description |
| :--- | :--- |
| `npm run start:dev` | Starts NestJS API server in development watch mode. |
| `npm run build` | Compiles NestJS TypeScript source code to `dist/`. |
| `npm run start:prod` | Runs compiled production backend from `dist/main.js`. |
| `npm run db:push` | Pushes Prisma schema changes directly to the database. |
| `npm run db:seed` | Populates database with default seed data (users, tenant, products). |
| `npm run db:studio` | Launches Prisma Studio GUI for database inspection. |
| `npm run test` | Executes Jest unit tests. |

---

## 🚀 Deployment Instructions

### Frontend (Vercel)
1. Push your project repository to GitHub / GitLab.
2. Connect your repository to [Vercel](https://vercel.com).
3. Set the Root Directory to `./`.
4. Configure Environment Variables: `NEXT_PUBLIC_API_URL`.
5. Deploy.

### Backend (Docker / VPS / AWS)
1. Build the production backend artifact:
   ```bash
   cd backend
   npm run build
   ```
2. Run database migrations:
   ```bash
   npx prisma migrate deploy
   ```
3. Launch with Node.js process manager (e.g., PM2) or Docker container:
   ```bash
   pm2 start dist/main.js --name "kasirpro-backend"
   ```

---

## 🤝 Contributing

Contributions, issues, and feature requests are welcome! Feel free to check the issues page or submit a pull request.

---

## 📄 License

This project is proprietary software / open-source under the MIT License.
