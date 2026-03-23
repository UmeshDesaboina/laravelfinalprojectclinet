# FightWisdom - Ecommerce Platform Specification

## Project Overview
- **Project Name**: FightWisdom Ecommerce
- **Type**: Full-stack Laravel Ecommerce Application
- **Core Functionality**: Complete ecommerce platform with admin dashboard, user management, product catalog, cart, checkout, orders, wishlist, reviews, coupons, and return management
- **Target Users**: Admin (store management) and Customers (shopping)

## Technology Stack
- **Framework**: Laravel 10.x
- **Frontend**: Blade Templates + Tailwind CSS + Vanilla JavaScript
- **Database**: MySQL
- **Authentication**: Laravel Breeze (customized)
- **Image Storage**: Laravel Storage

## Design System

### Color Palette
- **Dark**: #111827 (Gray 900)
- **Primary**: #22c55e (Green 500)
- **Primary Dark**: #16a34a (Green 600)
- **Light**: #f3f4f6 (Gray 100)
- **Background**: #ffffff
- **Text Primary**: #111827
- **Text Secondary**: #6b7280
- **Border**: #e5e7eb
- **Error**: #ef4444
- **Warning**: #f59e0b
- **Success**: #22c55e

### Typography
- **Font Family**: Inter (Google Fonts)
- **Headings**: Bold, tracking tight
- **Body**: Regular weight, leading relaxed

### Spacing System
- 4px base unit
- Section padding: 80px vertical

### Components Style
- Cards: Rounded-lg, shadow-md, hover:shadow-lg
- Buttons: Rounded-full for primary actions, rounded-lg for secondary
- Inputs: Rounded-lg with border
- Badges: Rounded-full

## Database Schema

### Users Table
- id, name, email, email_verified_at, password, role (admin/user), is_blocked, remember_token, timestamps

### Categories Table
- id, name, slug, description, status, timestamps

### Products Table
- id, category_id, name, slug, description, price, discount_price, delivery_charge, is_featured, sizes (JSON), status, timestamps

### Product Images Table
- id, product_id, image_path, is_primary, timestamps

### Orders Table
- id, user_id, total_amount, discount_amount, final_amount, status (pending/packed/shipped/delivered/cancelled), address_id, courier_name, tracking_id, payment_method (COD), notes, timestamps

### Order Items Table
- id, order_id, product_id, product_name, product_price, quantity, size, subtotal, timestamps

### Coupons Table
- id, code, type (flat/percentage), value, min_order_amount, expiry_date, usage_limit, used_count, status, timestamps

### Addresses Table
- id, user_id, name, phone, address_line1, address_line2, city, state, pincode, is_default, timestamps

### Reviews Table
- id, user_id, product_id, rating (1-5), comment, status (pending/approved/rejected), timestamps

### Wishlists Table
- id, user_id, product_id, timestamps

### Return Requests Table
- id, order_id, order_item_id, reason, status (requested/approved/rejected/picked/completed), admin_notes, timestamps

## Authentication & Authorization

### User Roles
- **admin**: Full access to admin dashboard
- **user**: Customer account for shopping

### Middleware
- `auth`: Protects user routes
- `admin`: Protects admin routes (admin role only)
- `verified`: Email verification (optional)

### Login Redirect Logic
- Admin role → /admin/dashboard
- User role → /

## Admin Dashboard Features

### Dashboard Stats
- Total orders count
- Total revenue (sum of completed orders)
- Total users count
- Recent 10 orders list

### Product Management
- List all products with pagination
- Add new product with multiple images
- Edit product (name, description, price, discount, category, sizes, delivery charge, featured status)
- Delete product
- Upload multiple images per product
- Manage variants (sizes as JSON array)
- Toggle featured products

### Category Management
- CRUD operations for categories
- Toggle category status (active/inactive)

### Order Management
- List all orders with status filter
- View order details
- Update order status (pending → packed → shipped → delivered)
- Add courier name and tracking ID when shipped
- Cancel orders

### User Management
- List all users
- View user details
- Block/unblock users
- View user's order history

### Coupon Management
- Create coupons (code, type, value, min order, expiry, usage limit)
- Edit/delete coupons
- Toggle coupon status

### Return Management
- View all return requests
- Approve/reject returns
- Update return status (requested → approved → picked → completed)

### Reports & Export
- Export orders to CSV
- Sales summary reports

## Frontend Features

### Navigation
- Logo
- Menu links (Home, Shop, Categories dropdown)
- Search bar
- User dropdown (Login/Register or Profile/Orders/Logout)
- Wishlist icon with count
- Cart icon with count

### Footer
- Company info
- Quick links
- Categories links
- Contact info
- Social links

### Home Page
- Hero section with CTA
- Featured products carousel (6 products)
- Categories grid (8 categories)
- Newsletter signup

### Shop Page
- Product grid (12 per page)
- Sidebar filters:
  - Category filter (checkbox)
  - Price range (min-max slider/inputs)
  - Size filter (checkbox)
- Sort options:
  - Price: Low to High
  - Price: High to Low
  - Newest First
  - Best Sellers
- Pagination

### Product Detail Page
- Image gallery with zoom
- Product info (name, price, discount)
- Size selector
- Quantity selector
- Add to Cart button
- Add to Wishlist button
- Product description tabs (Description, Reviews)
- Related products section

### Search
- Real-time search suggestions
- Search by product name
- Search by category name
- Display results with pagination

### Cart System
- Cart page listing all items
- Update quantity (+/-)
- Remove item
- Cart summary (subtotal, delivery, total)
- Guest cart (session-based)
- User cart (database)
- Move item to wishlist

### Checkout System (COD Only)
- Address selection (add new or select existing)
- Apply coupon code
- Order summary
- Place order button
- Order confirmation page

### User Account
- Profile page (view/edit)
- My Orders list
- Order details with status timeline
- Cancel order (if pending)
- My Addresses (add/edit/delete)
- My Wishlist
- My Reviews

### Wishlist
- List wishlist items
- Move to cart
- Remove from wishlist

### Reviews
- Submit review with rating (1-5 stars) and comment
- View approved reviews on product page
- Admin approval required

### Return/Replacement
- Request return from order details
- Select reason
- View return status timeline

## API Endpoints (Internal)

### Cart API
- GET /api/cart - Get cart items
- POST /api/cart/add - Add item to cart
- PUT /api/cart/{id} - Update quantity
- DELETE /api/cart/{id} - Remove item

### Wishlist API
- GET /api/wishlist - Get wishlist items
- POST /api/wishlist/add - Add item
- DELETE /api/wishlist/{id} - Remove item

### Search API
- GET /api/search?q={query} - Search products

### Coupon API
- POST /api/coupon/apply - Validate and apply coupon

## Validation Rules

### Product
- name: required, string, max:255
- category_id: required, exists:categories,id
- price: required, numeric, min:0
- discount_price: nullable, numeric, min:0
- delivery_charge: required, numeric, min:0
- description: required, string
- sizes: array
- images: array, max:5

### Order
- address_id: required, exists:addresses,id
- notes: nullable, string
- coupon_code: nullable, exists:coupons,code

### Review
- rating: required, integer, min:1, max:5
- comment: required, string, max:1000

### Coupon
- code: required, string, unique
- type: required, in:flat,percentage
- value: required, numeric, min:1
- min_order_amount: required, numeric, min:0
- expiry_date: required, date, after:today
- usage_limit: required, integer, min:1

## Page Templates

### Layouts
- `layouts.app` - Main frontend layout
- `layouts.admin` - Admin panel layout with sidebar
- `layouts.auth` - Auth pages layout

### Frontend Pages
- home.blade.php
- shop.blade.php
- product-detail.blade.php
- cart.blade.php
- checkout.blade.php
- order-confirmation.blade.php
- orders.blade.php
- order-detail.blade.php
- wishlist.blade.php
- profile.blade.php
- addresses.blade.php
- search.blade.php

### Auth Pages
- login.blade.php
- register.blade.php
- forgot-password.blade.php

### Admin Pages
- admin/dashboard.blade.php
- admin/products/index.blade.php
- admin/products/create.blade.php
- admin/products/edit.blade.php
- admin/categories/index.blade.php
- admin/orders/index.blade.php
- admin/orders/show.blade.php
- admin/users/index.blade.php
- admin/users/show.blade.php
- admin/coupons/index.blade.php
- admin/coupons/create.blade.php
- admin/coupons/edit.blade.php
- admin/returns/index.blade.php
- admin/reports/index.blade.php

## Components

### Frontend Components
- navbar.blade.php
- footer.blade.php
- product-card.blade.php
- category-card.blade.php
- cart-item.blade.php
- order-item.blade.php
- review-card.blade.php
- address-card.blade.php
- star-rating.blade.php
- toast.blade.php

### Admin Components
- sidebar.blade.php
- header.blade.php
- stats-card.blade.php
- data-table.blade.php
- image-upload.blade.php

## JavaScript Features

### Frontend
- Cart operations (add, update, remove)
- Wishlist operations (add, remove)
- Search suggestions
- Image gallery
- Star rating input
- Toast notifications
- Loading states
- Form validation

### Admin
- Product image preview
- Order status update
- Data table with filters
- CSV export

## Performance Optimizations

### Database
- Eager loading relationships
- Indexing on frequently queried columns
- Pagination (12 items per page frontend, 15 admin)
- Query caching where appropriate

### Images
- Lazy loading
- Responsive images
- WebP format support (optional)

## Error Handling
- Form validation errors displayed inline
- Session flash messages for success/error
- 404 page
- 500 error page
- Admin access denied page

## Security
- CSRF protection on all forms
- Mass assignment protection in models
- SQL injection prevention (Eloquent)
- XSS prevention (Blade escaping)
- Rate limiting on auth routes
