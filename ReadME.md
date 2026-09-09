# ERP — Quotation Generator (QG)

A scalable ERP-style quotation management system built for furniture and interior workflow automation.

Built using:

* PHP
* MySQL
* HTML
* CSS
* Vanilla JavaScript
* AJAX

The system is designed for modular furniture quotation workflows with dynamic costing architecture, nested relational management, ERP scalability and role-based access control.

---

# Core Features

## Authentication System

Supports secure authentication workflow:

* Login system
* Logout system
* Session-based authentication
* Protected routes
* Role-based permissions
* Permission-based sidebar rendering

---

# Role Based Access Control (RBAC)

The ERP supports modular permission architecture.

## Roles

* Super Admin
* Admin
* Sales Executive
* Production

---

## Permission System

Dynamic permission handling using:

```text
can('permission_name')
```

---

## Protected Modules

Permissions supported for:

* Dashboard access
* Create quotation
* Edit quotation
* Delete quotation
* View quotation
* User management
* Drawer management
* Shelf management
* Material management

---

# Dashboard System

Modern ERP dashboard with:

* Total quotations count
* Total quotation value
* Total project sqft
* Project type analytics
* Dynamic DB-driven statistics
* Responsive dashboard cards
* ERP analytics architecture

---

# Quotation Management

Supports complete quotation lifecycle:

* Create quotation
* View quotation
* Edit quotation
* Delete quotation
* Dynamic quotation restoration
* Nested relational data management

---

# Elevation Management

Features:

* Dynamic elevation generation
* Independent elevation handling
* Multiple elevations support
* Ceiling height MM ↔ FT conversion
* State-safe elevation rendering

---

# Unit Management

Supported unit types:

* Tall Units
* Upper Units
* Bottom Units
* Loft Units

Each unit supports:

* Overall dimensions
* Carcass calculations
* Shutter calculations
* Drawer costing
* Shelf costing
* Dynamic pricing
* Unit grand total

---

# Dynamic Costing Architecture

## Overall Dimensions

Used for:

* Reporting
* Total sqft
* Summary calculations
* Project analytics

---

# Carcass Calculations

Each unit supports:

* Carcass Width MM
* Carcass Width FT
* Carcass Height MM
* Carcass Height FT
* Carcass Sqft
* Carcass Material
* Carcass Price/Sq.Ft
* Carcass Total

Formula:

```text
Carcass Sqft × Carcass Price
```

---

# Shutter Calculations

Each unit supports:

* Shutter Category
* Shutter Material
* Shutter Width MM
* Shutter Width FT
* Shutter Height MM
* Shutter Height FT
* Shutter Sqft
* Shutter Price/Sq.Ft
* Shutter Total

Formula:

```text
Shutter Sqft × Shutter Price
```

---

# Drawer Calculations

Each drawer supports:

* Dynamic dimensions
* Width MM ↔ FT conversion
* Height MM ↔ FT conversion
* Sqft calculations
* Dynamic DB pricing
* Individual totals

Formula:

```text
Drawer Sqft × Drawer Price
```

---

# Shelf Calculations

Each shelf supports:

* Dynamic dimensions
* Width MM ↔ FT conversion
* Height MM ↔ FT conversion
* Sqft calculations
* Dynamic DB pricing
* Individual totals

Formula:

```text
Shelf Sqft × Shelf Price
```

---

# Final Unit Total

Each unit calculates:

```text
Carcass Total
+ Shutter Total
+ Drawer Totals
+ Shelf Totals
= Unit Grand Total
```

---

# Project Grand Total

Entire quotation calculates:

```text
All Unit Grand Totals
= Project Grand Total
```

---

# Full CRUD Workflow

## Create

Dynamic quotation generation with nested architecture.

---

## View

Displays:

* Client details
* Billing details
* Shipping details
* Elevations
* Units
* Carcass details
* Shutter details
* Drawers
* Shelves
* Totals
* Pricing hierarchy

---

## Edit

Supports dynamic restoration of:

```text
Quotation
 └── Elevations
      └── Units
           ├── Carcass
           ├── Shutter
           ├── Drawers
           └── Shelves
```

using JSON hydration architecture.

---

## Delete

Supports relational deletion of:

```text
Quotation
 └── Elevations
      └── Units
           ├── Drawers
           └── Shelves
```

---

# Database Structure

## Tables

### quotations

Stores:

* Client details
* Billing details
* Shipping details
* Project totals

---

### elevations

Stores:

* Elevation information
* Ceiling heights

---

### units

Stores:

* Unit dimensions
* Carcass calculations
* Shutter calculations
* Unit totals

---

### drawers

Stores drawer pricing master.

---

### drawers_data

Stores quotation drawer data.

---

### shelves

Stores shelf pricing master.

---

### shelves_data

Stores quotation shelf data.

---

### carcass_materials

Stores carcass pricing master.

---

### shutter_categories

Stores shutter category master.

---

### shutter_materials

Stores shutter material pricing.

---

### users

Stores ERP users.

---

### roles

Stores system roles.

---

### permissions

Stores modular permissions.

---

### role_permissions

Maps permissions to roles.

---

# Folder Structure

```text
/QG
│
├── assets
│   ├── css
│   ├── js
│   └── images
│
├── ajax
│   ├── create-unit.php
│   ├── generate-drawer.php
│   ├── generate-shelf.php
│   ├── generate-elevation.php
│   ├── get-shutter-materials.php
│   ├── save-quotation.php
│   ├── get-quotation.php
│   └── dashboard-data.php
│
├── auth
│   ├── login.php
│   ├── process-login.php
│   └── logout.php
│
├── users
│   ├── index.php
│   ├── manage-users.php
│   ├── roles.php
│   └── permissions.php
│
├── components
│   ├── elevation.php
│   ├── tall-unit.php
│   ├── upper-unit.php
│   ├── bottom-unit.php
│   ├── loft-unit.php
│   ├── material-section.php
│   ├── drawer-section.php
│   ├── drawer-card.php
│   ├── shelf-section.php
│   └── shelf-card.php
│
├── includes
│   ├── auth.php
│   ├── permissions.php
│   ├── header.php
│   ├── footer.php
│   └── sidebar.php
│
├── quotations
│   ├── create.php
│   ├── manage.php
│   ├── view.php
│   ├── edit.php
│   ├── save.php
│   ├── update.php
│   └── delete.php
│
├── drawer
│
├── shelf
│
├── materials
│
├── dashboard.php
│
└── db.php
```

---

# Dynamic AJAX Architecture

Used for:

* Elevation generation
* Unit generation
* Drawer generation
* Shelf generation
* Shutter material loading
* Quotation restoration
* Dynamic pricing
* State-safe rendering

---

# Dynamic Restoration Engine

The edit system dynamically restores:

```text
Quotation
 └── Elevations
      └── Units
           ├── Carcass
           ├── Shutter
           ├── Drawers
           └── Shelves
```

using nested JSON hydration.

---

# Sidebar System

Features:

* Mobile responsive sidebar
* Active link detection
* Font Awesome icons
* Overlay support
* Sidebar open/close support
* Dynamic route highlighting
* Permission-based rendering

---

# Modern UI Architecture

UI system includes:

* Glassmorphism login screen
* Responsive layouts
* ERP-style dashboard
* Mobile-safe forms
* Dynamic cards
* Premium color palette
* Crafted brand identity integration

---

# Technologies Used

| Technology   | Usage             |
| ------------ | ----------------- |
| PHP          | Backend           |
| MySQL        | Database          |
| AJAX         | Dynamic rendering |
| JavaScript   | Calculations      |
| HTML         | Structure         |
| CSS          | Styling           |
| Font Awesome | Icons             |

---

# Current ERP Architecture

```text
Project
 └── Elevation
      └── Unit
           ├── Overall Dimensions
           ├── Carcass
           ├── Shutter
           ├── Drawers
           ├── Shelves
           └── Final Cost
```

---

# ERP Design Principles

* No hardcoded pricing
* Dynamic DB-driven pricing
* Nested relational architecture
* Modular components
* Scalable ERP design
* Reusable AJAX architecture
* State-safe generation
* State-safe restoration
* ERP-ready structure
* RBAC-ready architecture


---

# Author
Rishikumar Yadav
