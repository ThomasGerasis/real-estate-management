# Next.js Real Estate Frontend Integration Plan

## ✅ YES, This is 100% Possible!

Your Filament backend is perfect for this Next.js template. Here's the complete integration strategy:

## Architecture Overview

```
┌─────────────────────────────────────────────────────────────┐
│                     YOUR SETUP                              │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  ┌──────────────────────┐         ┌────────────────────┐  │
│  │   Next.js Frontend   │  ◄──────│   Laravel API      │  │
│  │  (Homez Template)    │  JSON   │  (Your Backend)    │  │
│  │                      │         │                    │  │
│  │  - Property Listings │         │  - Filament Admin  │  │
│  │  - Search & Filters  │         │  - Properties CRUD │  │
│  │  - Agent Profiles    │         │  - Agents, Cities  │  │
│  │  - Blog Posts        │         │  - Posts, Pages    │  │
│  │  - Pages (About etc) │         │  - API Endpoints   │  │
│  └──────────────────────┘         └────────────────────┘  │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

## What You Need to Build

### 1. ✅ API (REQUIRED)
**Purpose:** Serve data to Next.js frontend

**Endpoints Needed:**
```
GET  /api/properties              - List properties (with filters)
GET  /api/properties/{id}         - Single property details
GET  /api/properties/featured     - Featured properties
GET  /api/properties/search       - Advanced search

GET  /api/agents                  - List agents
GET  /api/agents/{id}             - Agent profile + properties

GET  /api/cities                  - List cities
GET  /api/districts/{cityId}      - Districts by city

GET  /api/posts                   - Blog posts
GET  /api/posts/{slug}            - Single post

GET  /api/pages/{slug}            - Pages (About, Contact, etc.)

GET  /api/menu                    - Main menu items
GET  /api/footer-menu             - Footer menu items
GET  /api/settings                - Site settings (logo, contact, etc.)
```

### 2. ✅ Menu Management in Filament (RECOMMENDED)
**Why:** Non-technical users can manage menus without code changes

**What to Create:**
- `Menu` model (main navigation)
- `FooterMenu` model (footer links)
- Filament resources for both
- Store menu items with: label, url, order, parent_id (for submenus)

**Alternative:** Use Pages model with `show_in_menu` flag (you already have this!)

### 3. ✅ Pages System (ALREADY DONE!)
**You already have this!**
- About Us
- Contact
- Services
- Privacy Policy
- Terms & Conditions
- FAQ

Pages are perfect for static content that changes rarely.

### 4. ✅ Posts/Blog (ALREADY DONE!)
**You already have this!**
The template likely has a blog section - use your Posts model.

### 5. ✅ Site Settings in Filament (RECOMMENDED)
**What to Create:**
- Settings model for global config
- Fields: site_name, logo, phone, email, address, social_media, etc.
- Single settings page in Filament

### 6. ❌ Widgets in Frontend (NO FILAMENT WIDGETS)
**Important:** Filament widgets are for admin dashboard only!

**For Frontend Widgets, Use:**
- Next.js components
- Fetch data from API
- Examples:
  - "Featured Properties" widget → API call
  - "Latest Posts" widget → API call
  - "Search Widget" → Client-side form
  - "Statistics" widget → API call to get counts

## Recommended Implementation Plan

### Phase 1: API Development (Week 1)

**Install Laravel Sanctum (for API):**
```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\ServiceProvider"
php artisan migrate
```

**Create API Controllers:**
```php
// app/Http/Controllers/Api/PropertyController.php
// app/Http/Controllers/Api/AgentController.php
// app/Http/Controllers/Api/PostController.php
// app/Http/Controllers/Api/PageController.php
// app/Http/Controllers/Api/MenuController.php
```

**Create API Resources (for JSON formatting):**
```php
// app/Http/Resources/PropertyResource.php
// app/Http/Resources/AgentResource.php
// etc.
```

**Define API Routes:**
```php
// routes/api.php
Route::prefix('v1')->group(function () {
    Route::get('properties', [PropertyController::class, 'index']);
    Route::get('properties/{property}', [PropertyController::class, 'show']);
    Route::get('properties/search', [PropertyController::class, 'search']);
    // ... more routes
});
```

### Phase 2: Menu Management (Week 1-2)

**Option A: Simple - Use Pages**
```php
// API endpoint
GET /api/menu
// Returns all pages where show_in_menu = true, ordered by sort_order
```

**Option B: Advanced - Menu Model**
```bash
php artisan make:model Menu -m
php artisan make:filament-resource Menu
```

```php
// Menu structure
- id
- label (e.g., "Home", "Properties", "About")
- url (e.g., "/", "/properties", "/about")
- parent_id (for dropdowns)
- sort_order
- is_active
- location (main, footer, both)
```

### Phase 3: Site Settings (Week 2)

**Create Settings Model:**
```bash
php artisan make:model Setting -m
php artisan make:filament-resource Setting
```

```php
// Settings fields
- site_name
- site_logo
- contact_email
- contact_phone
- address
- facebook_url
- twitter_url
- instagram_url
- linkedin_url
- footer_text
- google_analytics_id
```

**Single Settings Page in Filament:**
```php
// Use Filament's Pages feature for a single settings form
php artisan make:filament-page Settings
```

### Phase 4: Frontend Widgets (Week 2-3)

**Widgets are Next.js Components + API Calls:**

```typescript
// components/widgets/FeaturedProperties.tsx
export default function FeaturedProperties() {
  const { data } = useSWR('/api/properties/featured', fetcher);
  
  return (
    <div className="featured-properties">
      {data?.map(property => (
        <PropertyCard key={property.id} property={property} />
      ))}
    </div>
  );
}
```

```typescript
// components/widgets/LatestPosts.tsx
export default function LatestPosts() {
  const { data } = useSWR('/api/posts?limit=3', fetcher);
  
  return (
    <div className="latest-posts">
      {data?.map(post => (
        <BlogCard key={post.id} post={post} />
      ))}
    </div>
  );
}
```

## API Response Examples

### Property List
```json
{
  "data": [
    {
      "id": 1,
      "title": "Modern Apartment in Berlin Mitte",
      "slug": "modern-apartment-berlin-mitte",
      "listing_type": "sale",
      "price": 450000,
      "bedrooms": 2,
      "bathrooms": 1,
      "square_meters": 75.5,
      "energy_class": "A",
      "images": [
        "https://yourdomain.com/storage/properties/image1.jpg",
        "https://yourdomain.com/storage/properties/image2.jpg"
      ],
      "city": {
        "id": 1,
        "name": "Berlin"
      },
      "district": {
        "id": 1,
        "name": "Mitte"
      },
      "agent": {
        "id": 1,
        "name": "John Smith",
        "photo": "https://yourdomain.com/storage/agents/john.jpg"
      },
      "seo": {
        "title": "Modern Apartment in Berlin Mitte - Berlin - For Sale",
        "description": "Apartment sale in Berlin. €450,000. 2 bed, 1 bath..."
      }
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 50,
    "per_page": 12
  }
}
```

### Menu API
```json
{
  "main_menu": [
    {
      "id": 1,
      "label": "Home",
      "url": "/",
      "children": []
    },
    {
      "id": 2,
      "label": "Properties",
      "url": "/properties",
      "children": [
        {
          "id": 3,
          "label": "For Sale",
          "url": "/properties?listing_type=sale"
        },
        {
          "id": 4,
          "label": "For Rent",
          "url": "/properties?listing_type=rent"
        }
      ]
    },
    {
      "id": 5,
      "label": "About",
      "url": "/about"
    }
  ]
}
```

## Directory Structure

```
your-project/
├── backend/                    (Laravel + Filament)
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   └── Api/
│   │   │   │       ├── PropertyController.php
│   │   │   │       ├── AgentController.php
│   │   │   │       ├── PostController.php
│   │   │   │       ├── PageController.php
│   │   │   │       └── MenuController.php
│   │   │   └── Resources/
│   │   │       ├── PropertyResource.php
│   │   │       └── ...
│   │   ├── Models/
│   │   │   ├── Property.php
│   │   │   ├── Menu.php
│   │   │   └── Setting.php
│   │   └── Filament/
│   │       └── Resources/
│   │           ├── PropertyResource.php (admin)
│   │           ├── MenuResource.php (admin)
│   │           └── ...
│   └── routes/
│       ├── api.php              ← API routes
│       └── web.php
│
└── frontend/                   (Next.js + Homez Template)
    ├── components/
    │   ├── properties/
    │   │   ├── PropertyCard.tsx
    │   │   └── PropertyList.tsx
    │   ├── widgets/
    │   │   ├── FeaturedProperties.tsx
    │   │   ├── SearchWidget.tsx
    │   │   └── LatestPosts.tsx
    │   └── layout/
    │       ├── Header.tsx        ← Fetch menu from API
    │       └── Footer.tsx        ← Fetch footer menu from API
    ├── pages/
    │   ├── properties/
    │   │   ├── index.tsx         ← List properties
    │   │   └── [slug].tsx        ← Property details
    │   ├── agents/
    │   ├── blog/
    │   └── [slug].tsx            ← Dynamic pages (About, Contact)
    └── lib/
        └── api.ts                ← API client
```

## Do You Need Pages & Posts?

### ✅ YES - Pages are Essential
**Why:**
- About Us
- Contact
- Terms & Conditions
- Privacy Policy
- FAQ
- Services

**Benefits:**
- Non-technical users can edit content
- No code deployment needed
- SEO-friendly
- Version control (draft/published)

### ✅ YES - Posts/Blog are Recommended
**Why:**
- SEO boost (fresh content)
- Market updates
- Property showcases
- Investment tips
- Neighborhood guides

**Benefits:**
- Drive organic traffic
- Establish authority
- Engage visitors
- Better Google rankings

## Implementation Steps

### Step 1: Create Menu System (2-3 days)

```bash
cd /home/thomas/Websites/real-estate/src

# Create Menu model
php artisan make:model Menu -m
php artisan make:filament-resource Menu

# Create Setting model
php artisan make:model Setting -m
php artisan make:filament-page ManageSettings
```

### Step 2: Build API (3-5 days)

```bash
# Install Sanctum
composer require laravel/sanctum

# Create API controllers
php artisan make:controller Api/PropertyController --api
php artisan make:controller Api/AgentController --api
php artisan make:controller Api/PostController --api
php artisan make:controller Api/PageController --api

# Create API resources
php artisan make:resource PropertyResource
php artisan make:resource PropertyCollection
```

### Step 3: Set Up Next.js (2-3 days)

```bash
# In a separate directory
npx create-next-app@latest frontend
cd frontend

# Install dependencies
npm install axios swr
npm install @tanstack/react-query (or SWR)

# Copy Homez template files into project
# Configure API endpoint to your Laravel backend
```

### Step 4: Connect & Test (2-3 days)

- Set up CORS in Laravel
- Test API endpoints
- Fetch data in Next.js
- Build property listing page
- Build property detail page

## CORS Setup (Important!)

```php
// config/cors.php
'paths' => ['api/*'],
'allowed_methods' => ['*'],
'allowed_origins' => ['http://localhost:3000'], // Next.js dev server
'allowed_origins_patterns' => [],
'allowed_headers' => ['*'],
'exposed_headers' => [],
'max_age' => 0,
'supports_credentials' => false,
```

## Next Steps - Recommended Order

1. ✅ **Create Menu Management** (this allows frontend navigation)
2. ✅ **Create Settings Page** (site-wide config)
3. ✅ **Build API Endpoints** (properties, agents, posts, pages)
4. ✅ **Test API with Postman/Insomnia**
5. ✅ **Set Up Next.js Project** (with Homez template)
6. ✅ **Connect Frontend to API**
7. ✅ **Build Page by Page**

## Estimated Timeline

- **API Development**: 1 week
- **Menu & Settings**: 2-3 days
- **Next.js Setup**: 1 week
- **Integration & Testing**: 3-5 days
- **Total**: 2.5 - 3 weeks

## Summary

### ✅ What You Have (Already Great!)
- Properties with all details
- Listing types (sale/rent)
- Cities & Districts
- Agents
- Posts/Blog
- Pages (About, Contact, etc.)
- SEO metadata

### ✅ What You Need to Add
1. **API Endpoints** (essential)
2. **Menu Management** (recommended)
3. **Site Settings** (recommended)

### ❌ What You DON'T Need
- Filament widgets for frontend (use Next.js components)
- Complex widget management (fetch data via API instead)

**Want me to create the Menu system and API controllers next?** 🚀
