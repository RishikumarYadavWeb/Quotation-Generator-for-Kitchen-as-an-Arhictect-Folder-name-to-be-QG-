# QUOTATION GENERATOR SYSTEM

## Technical Architecture & Implementation Documentation

**Version:** 1.0
**Document Type:** Technical Design & Developer Guide
**Prepared By:** RishiKumar Yadav
**Project Type:** Enterprise Web Application
**Technology Stack:** PHP, MySQL, HTML, CSS, JavaScript, AJAX, Bootstrap

---

# 1. PROJECT OVERVIEW

## 1.1 Introduction

The Quotation Generator System is an enterprise-grade web application developed to automate the complete quotation lifecycle for modular interior projects.

The application replaces manual quotation preparation processes traditionally performed using spreadsheets and document editors.

The system centralizes pricing logic, automates calculations, standardizes quotation generation, provides role-based access control, and generates professional PDF quotations.

The platform is designed to support multiple business entities operating under the same system.

---

## 1.2 Technologies Used

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

# 2. BUSINESS PROBLEM STATEMENT

Prior to implementation, the quotation workflow suffered from:

* Manual quotation preparation.
* Duplicate pricing entries.
* Human calculation errors.
* Inconsistent quotation formats.
* No centralized pricing management.
* Lack of user access controls.
* Difficulty tracking quotations.
* No auditability.
* Time-consuming revision processes.
* Absence of analytics and reporting.

The objective was to build a centralized, scalable, multi-entity quotation management platform.

---

# 3. SYSTEM FEATURES

## Core Modules

### Master Management

Responsible for maintaining all pricing masters.

Modules include:

* Carcass Categories
* Carcass Materials
* Shutter Categories
* Shutter Materials
* Drawer Categories
* Shelves
* Accessories
* Entities
* Roles
* Permissions
* Users

---

### Client Management

Stores:

* Client information
* Contact details
* Billing addresses
* Shipping addresses
* GST information

---

### Quotation Management

Allows users to:

* Create quotations.
* Edit quotations.
* Save draft quotations.
* View quotations.
* Delete quotations.
* Generate PDF quotations.

---

### Elevation Management

Each quotation can contain multiple elevations.

Examples:

* Elevation A
* Elevation B

Each elevation can contain multiple units.

---

### Unit Management

Every elevation contains units classified as:

* Tall Unit
* Upper Unit
* Bottom Unit
* Loft Unit

Each unit stores:

* Width
* Height
* Depth
* Square Foot Area
* Material Selections
* Pricing

---

### Dashboard Module

Separate dashboards implemented:

* Super Admin Dashboard
* Craftred Dashboard
* F&R Dashboard

Dashboard metrics include:

* Total Quotations
* Monthly Quotations
* Total Revenue
* User-wise Quotations
* Entity-wise Analytics

---

# 4. HIGH LEVEL ARCHITECTURE

```text
User
 ↓
Browser
 ↓
Frontend (HTML/CSS/JS)
 ↓
AJAX Layer
 ↓
PHP Controllers
 ↓
Business Logic Layer
 ↓
MySQL Database
 ↓
PDF Generation Layer
 ↓
Quotation PDF
```

---

# 5. APPLICATION ARCHITECTURE

The application follows a layered architecture.

## Layer 1 — Presentation Layer

Files:

```text
create.php
edit.php
view.php
manage.php
dashboard.php
```

Responsibilities:

* User interaction.
* Rendering forms.
* Data visualization.
* Client-side validation.

Technologies:

* HTML5
* CSS3
* Bootstrap
* Vanilla JavaScript

---

## Layer 2 — Client Side Business Logic

Files:

```text
script.js
elevation.js
unit.js
```

Responsibilities:

* Dynamic UI rendering.
* Realtime calculations.
* AJAX requests.
* Grand total calculations.
* Material loading.

---

## Layer 3 — Server Side Business Logic

Files:

```text
save.php
update.php
delete.php
fetch_*.php
```

Responsibilities:

* CRUD operations.
* Business validations.
* Permission checks.
* Data persistence.

---

## Layer 4 — Database Layer

Technology:

```text
MySQL
```

Responsibilities:

* Persistent storage.
* Relationship management.
* Pricing master storage.

---

# 6. DATABASE DESIGN

## Major Tables

---

## users

Stores application users.

Important Columns:

```text
id
entity_id
role_id
name
email
password
status
```

Relationship:

```text
users.role_id -> roles.id
users.entity_id -> entities.id
```

---

## roles

Stores available roles.

Examples:

```text
Super Admin
Admin
Sales Executive
Designer
```

---

## permissions

Stores all system permissions.

Examples:

```text
quotation_create
quotation_edit
quotation_delete
dashboard_view
master_manage
```

---

## role_permissions

Maps roles to permissions.

Structure:

```text
role_id
permission_id
```

Used by:

```php
can('permission_name')
```

---

## entities

Supports multi-company architecture.

Current entities:

```text
Craftred
F&R Kitchens and Wardrobes Pvt Ltd
```

Stores:

```text
company_name
registered_address
admin_address
gst_number
pan_number
email
logo
```

---

## clients

Stores customer information.

Fields:

```text
name
phone
email
billing_address
shipping_address
gst_number
```

---

## quotations

Master quotation record.

Stores:

```text
quotation_number
client_id
entity_id
created_by
grand_total
packing_charge
installation_charge
special_discount
final_customer_price
status
created_at
```

Relationships:

```text
quotation -> users
quotation -> clients
quotation -> entities
```

---

## elevations

Stores quotation elevations.

Relationship:

```text
quotation_id
```

One quotation can have multiple elevations.

---

## units

Stores all units.

Relationship:

```text
elevation_id
```

Stores:

```text
unit_type
width_mm
height_mm
depth_mm
sqft
carcass_material_id
shutter_material_id
```

---

## accessories

Stores accessory pricing.

Examples:

```text
Handles
Profile Lights
Magic Corner
Basket
```

---

# 7. QUOTATION CREATION FLOW

## Step 1

User opens:

```text
create.php
```

---

## Step 2

Entity resolved.

Logic:

### Super Admin

Can select entity manually.

### Normal User

Entity automatically fetched from session.

```php
$_SESSION['entity_id']
```

---

## Step 3

User enters:

* Client Details
* Project Information
* Addresses

---

## Step 4

User adds elevations.

Example:

```text
Kitchen Elevation 1
Wardrobe Elevation
```

---

## Step 5

For each elevation:

Generate units.

Example:

```text
Tall = 2
Upper = 4
Bottom = 5
Loft = 3
```

Dynamic JS generates tables.

Function:

```javascript
generateUnits()
```

---

## Step 6

User selects:

```text
Carcass Category
Carcass Material

Shutter Category
Shutter Material
```

Material dropdowns load via AJAX.

Functions:

```javascript
loadCarcassMaterials()
loadShutterMaterials()
```

---

## Step 7

Square feet calculation.

Formula:

```text
(width_mm / 304.8) *
(height_mm / 304.8)
```

Function:

```javascript
calculateUnitSqft()
```

---

## Step 8

Carcass amount calculation.

Formula:

```text
Unit Sqft × Material Rate
```

Function:

```javascript
calculateCarcassAmount()
```

---

## Step 9

Shutter amount calculation.

Formula:

```text
Unit Sqft × Material Rate
```

---

## Step 10

Drawer, shelf and accessories calculations.

Totals propagate upwards.

---

## Step 11

Grand total calculation.

Function:

```javascript
updateGrandTotal()
```

Formula:

```text
Unit Total
+ Accessories
+ Packing Charges
+ Installation Charges
- Discount
```

Final output:

```text
Final Customer Price
```

---

# 8. FRONTEND COMPONENT STRUCTURE

Reusable Components:

```text
drawer-card.php
shelf-card.php
material-section.php
create-unit.php
```

Purpose:

To avoid duplicate UI code.

Future developers should extend these components instead of hardcoding UI.

---

# 9. JAVASCRIPT CALCULATION ENGINE

Primary file:

```text
script.js
```

Critical functions:

## calculateUnitSqft()

Calculates unit area.

---

## calculateCarcassAmount()

Calculates carcass price.

---

## calculateShutterAmount()

Calculates shutter price.

---

## calculateGrandUnitTotal()

Calculates total for single unit.

---

## updateGrandTotal()

Calculates complete quotation total.

---

## convertMMFT()

Converts millimeters to feet.

---

## convertFTMM()

Converts feet to millimeters.

---

# 10. DYNAMIC MATERIAL LOADING

Material hierarchy:

```text
Category
    ↓
Material
```

Example:

```text
Membrane
   ↓
High Gloss White
```

AJAX endpoints:

```text
fetch_carcass_materials.php
fetch_shutter_materials.php
```

Whenever category changes:

```javascript
onchange
```

AJAX populates materials.

Future developers must preserve:

```text
category_id
material_id
```

mapping.

---

# 11. PDF GENERATION

Technology:

```text
DOMPDF
```

Purpose:

Generate professional quotation PDFs.

Features:

* Company branding.
* Entity logos.
* Page numbering.
* Footer.
* Headers.
* Automatic page breaks.

Files:

```text
invoice-template.php
pdf.php
```

Challenges solved:

* Custom font loading.
* Footer positioning.
* Page numbering.
* Large table rendering.
* Multi-page elevations.
* Rupee symbol rendering.
* Layout consistency.

Important:

Any PDF design changes should happen only inside:

```text
invoice-template.php
```

---

# 12. ROLE BASED ACCESS CONTROL

Permission helper:

```php
can('permission_name')
```

Flow:

```text
User
 ↓
Role
 ↓
Role Permission Mapping
 ↓
Permission Validation
```

Example:

```php
if(can('quotation_create'))
```

Future permissions must be:

1. Added in permissions table.
2. Mapped in role_permissions.
3. Used in UI.

---

# 13. SESSION ARCHITECTURE

Critical Session Variables:

```php
$_SESSION['user_id']
$_SESSION['role_id']
$_SESSION['entity_id']
$_SESSION['role_name']
```

Used throughout application.

Never remove these.

---

# 14. MULTI ENTITY IMPLEMENTATION

Architecture:

```text
One Application
        ↓
Multiple Companies
```

Filtering logic:

Super Admin:

```text
Can view all quotations.
```

Normal Users:

```text
Can only view their entity quotations.
```

Dashboards:

```text
crdashboard.php
frdashboard.php
```

Filter:

```sql
WHERE entity_id = X
```

---

# 15. FILE STRUCTURE RECOMMENDATION

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

# 16. COMMON CHANGE REQUEST GUIDE

## Add New Permission

Steps:

1. Insert in permissions table.
2. Assign to role.
3. Add can() check.

---

## Add New Material Type

Steps:

1. Create master table.
2. Create CRUD.
3. Update create/edit screens.
4. Update save/update logic.
5. Update calculation engine.

---

## Add New Dashboard KPI

Modify:

```text
dashboard.php
```

Add corresponding SQL query.

---

## Modify Pricing Logic

Primary files:

```text
script.js
save.php
update.php
```

Always update frontend and backend together.

---

# 17. PERFORMANCE CONSIDERATIONS

Current optimizations:

* AJAX material loading.
* Reusable UI components.
* Master data normalization.
* Session-based filtering.

Future recommendations:

* Implement pagination.
* Introduce caching.
* Add API layer.
* Migrate to MVC architecture.
* Consider Laravel migration.

---

# 18. KNOWN TECHNICAL DEBT

* Project currently follows procedural PHP.
* Business logic partially mixed with UI.
* Limited service abstraction.
* No automated test suite.
* No ORM usage.
* No centralized exception handling.

Recommended future enhancement:

Migration to:

```text
Laravel + Repository Pattern + Service Layer
```

---

# 19. ELEVATION IMAGE MANAGEMENT MODULE

## Overview

The system supports storing multiple line drawings and elevation reference images for each elevation.

This feature enables designers and sales teams to attach architectural drawings, sketches, and visual references directly to individual elevations.

---

## Database Structure

### Table: elevation_line_images

```text
id
elevation_id
image_path
image_title
created_at
```

Relationship:

```text
elevation_line_images.elevation_id
        ↓
elevations.id
```

Constraint:

```sql
FOREIGN KEY (elevation_id)
REFERENCES elevations(id)
ON DELETE CASCADE
```

---

## Features

* Multiple images per elevation.
* Image upload during quotation creation.
* Image upload during quotation edit.
* Existing image preview.
* Existing image deletion.
* New image addition without removing old images.
* Automatic file cleanup during deletion.
* Elevation-wise image segregation.

---

## Frontend Architecture

Images are managed through:

```javascript
window.elevationImages
window.oldElevationImages
window.deletedImages
```

### Responsibilities

### window.elevationImages

Stores newly selected images.

```javascript
Map<FileInput, File[]>
```

---

### window.oldElevationImages

Stores previously saved images.

Structure:

```javascript
{
    1: ['img1.jpg','img2.jpg'],
    2: ['img3.jpg']
}
```

Key:

```text
elevation_no
```

---

### window.deletedImages

Tracks removed images.

Used during update workflow.

Example:

```javascript
[
    "old_img_1.jpg",
    "old_img_2.jpg"
]
```

---

## Upload Workflow

```text
User Selects Images
        ↓
Frontend Stores Images
        ↓
AJAX Upload
        ↓
upload-elevation-images.php
        ↓
Physical File Storage
        ↓
JSON Response
        ↓
Quotation Save/Update
        ↓
Database Mapping
```

---

## Important Design Decision

Image mapping during update uses:

```text
elevation_no
```

instead of:

```text
elevation_id
```

Reason:

Elevation IDs are recreated during quotation updates.

Using elevation numbers guarantees correct image reassignment.

---

# 20. QUOTATION UPDATE WORKFLOW

## Overview

The update mechanism completely rebuilds quotation hierarchy.

Workflow:

```text
Quotation
    ↓
Elevations
        ↓
Units
            ↓
Drawers
            ↓
Shelves
            ↓
Accessories
```

---

## Update Strategy

Current implementation follows:

```text
Delete + Recreate
```

Approach.

Process:

1. Update quotation master.
2. Update client information.
3. Delete existing accessories.
4. Delete existing shelves.
5. Delete existing drawers.
6. Delete existing units.
7. Delete existing elevations.
8. Recreate elevations.
9. Recreate units.
10. Reassign images.
11. Commit transaction.

---

## Transaction Management

Entire update operation executes inside:

```php
mysqli_begin_transaction()
```

Rollback occurs on:

```php
Exception
```

using:

```php
mysqli_rollback()
```

This ensures:

* Data consistency.
* Atomic updates.
* Referential integrity.

---

# 21. CALCULATION ENGINE ARCHITECTURE

## Total Calculation Hierarchy

```text
Carcass Total
+ Shutter Total
+ Drawer Total
+ Shelf Total
--------------------------------
Unit Total

All Unit Totals
+ Accessories Total
--------------------------------
Base Total

Base Total
+ Packing
+ Installation
--------------------------------
Grand Total

Grand Total
- Discount
--------------------------------
Final Customer Price
```

---

## Core Functions

### calculateRowTotal()

Calculates:

```text
Single Unit Material Total
```

---

### calculateGrandUnitTotal()

Calculates:

```text
Complete Unit Total
```

Includes:

* Carcass
* Shutters
* Drawers
* Shelves

---

### updateGrandTotal()

Calculates:

```text
Entire Quotation Total
```

Includes:

* Unit Totals
* Accessories
* Packing
* Installation

---

### calculateFinalPricing()

Calculates:

```text
Final Customer Price
```

after discount.

---

# 22. KNOWN COMPLEX AREAS

Future developers should exercise caution while modifying:

## High-Risk Modules

```text
edit.php
update-quotation.php
update.js
unit.js
invoice-template.php
```

Reason:

These files contain tightly coupled business logic.

Any modification should be regression tested thoroughly.

---

# 23. COMMON DEBUGGING SCENARIOS

## Issue

Images saved under incorrect elevation.

Cause:

Incorrect elevation mapping.

Resolution:

Use:

```php
$uploadedLineImages[$elevationNo]
```

instead of:

```php
$uploadedLineImages[$index]
```

---

## Issue

Frontend and PDF totals mismatch.

Cause:

Calculation logic mismatch.

Resolution:

Verify:

```text
Unit Total
Accessories
Packing
Installation
Discount
GST
```

across:

```text
Frontend
Database
PDF
```

---

## Issue

JSON parsing error.

Example:

```javascript
Unexpected token '<'
```

Cause:

PHP warnings or debug statements.

Resolution:

Ensure APIs return only:

```json
{
    "status": true
}
```

No debug output should be echoed.

---

# 24. FUTURE ROADMAP

Recommended future enhancements:

* Laravel migration.
* REST API architecture.
* JWT authentication.
* Audit trail implementation.
* Soft delete support.
* Activity logs.
* Quotation versioning.
* Approval workflows.
* Email quotation delivery.
* WhatsApp quotation sharing.
* Image annotation support.
* Redis caching.
* Docker containerization.
* CI/CD pipeline.
* Automated testing suite.
* Cloud storage integration for drawings.

# 25. CONCLUSION

The Quotation Generator is a mission-critical enterprise application designed to automate interior quotation workflows while supporting multiple business entities, centralized pricing, secure access control, and professional quotation generation.

Future enhancements should preserve the existing pricing engine, RBAC framework, and multi-entity architecture while progressively refactoring toward a modern MVC architecture.
