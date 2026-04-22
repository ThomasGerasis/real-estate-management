# Shortcodes Documentation

This CMS supports shortcodes that allow you to embed dynamic content in your pages and posts.

## Available Shortcodes

### 1. Properties Listing - `[properties]`

Display a list of properties with optional filters.

**Attributes:**
- `limit` - Number of properties to show (default: 6)
- `type` - Filter by property type: `house`, `apartment`, `commercial`, `land`
- `listing_type` - Filter by listing type: `sale`, `rent`
- `featured` - Show only featured properties: `true`, `false`

**Examples:**
```
[properties]
[properties limit="3"]
[properties type="apartment" listing_type="rent"]
[properties featured="true" limit="4"]
[properties type="house" listing_type="sale" limit="6"]
```

### 2. Contact Form - `[contact_form]`

Embed a contact form that saves submissions to the admin panel.

**Attributes:**
- `title` - Form heading (default: "Contact Us")

**Examples:**
```
[contact_form]
[contact_form title="Get In Touch"]
[contact_form title="Request Property Information"]
```

### 3. FAQ Section - `[faq]`

Display frequently asked questions in an accordion format.

**Attributes:**
- `category` - Show only FAQs from a specific category
- `limit` - Maximum number of FAQs to display

**Examples:**
```
[faq]
[faq category="Properties"]
[faq category="General" limit="5"]
[faq limit="10"]
```

### 4. Property Inquiry Form - `[property_inquiry_form]`

Embed a form for inquiring about a specific property. Submissions saved as `property_inquiry` type.

**Attributes:**
- `title` - Form heading (default: "Property Inquiry")
- `property_id` - Pre-fill a specific property ID (optional)

**Examples:**
```
[property_inquiry_form]
[property_inquiry_form title="Ask About This Property"]
[property_inquiry_form property_id="42" title="Request Viewing"]
```

### 5. General Inquiry Form - `[inquiry_form]`

Embed a search-style form for buyers/renters looking for a property. Submissions saved as `general_inquiry` type.

**Attributes:**
- `title` - Form heading (default: "Find Your Property")
- `city_id` - Pre-select a city by ID (optional)
- `listing_type` - Pre-select listing type: `sale`, `rent` (optional)
- `property_type` - Pre-select property type: `house`, `apartment`, `commercial`, `land` (optional)

**Examples:**
```
[inquiry_form]
[inquiry_form title="Looking to Buy?"]
[inquiry_form listing_type="rent" title="Find a Rental"]
[inquiry_form listing_type="sale" property_type="apartment"]
```

### 6. Mandate Form - `[mandate_form]`

Embed a form for property owners who want to list their property for sale or rent through the agency. Submissions saved as `mandate` type.

**Attributes:**
- `title` - Form heading (default: "List Your Property")

**Examples:**
```
[mandate_form]
[mandate_form title="Sell or Rent Your Property"]
[mandate_form title="Request a Free Valuation"]
```

## Usage in CMS

1. Go to **Pages** or **Posts** in the admin panel
2. In the content editor, insert any shortcode using the syntax above
3. Save and publish your content
4. The shortcode will be automatically processed and rendered on the frontend

## Tips

- Shortcodes are case-sensitive, use lowercase
- Attribute values should be in quotes: `attr="value"`
- You can use multiple shortcodes in the same content
- Shortcodes only work in content fields (not in titles or meta descriptions)

## Managing Content

### Properties
Manage properties in: **Admin Panel → Properties**

### Contact Submissions
View submissions in: **Admin Panel → Contact Submissions**

### FAQs
Manage FAQs in: **Admin Panel → FAQs**
- Organize by category
- Set display order with `sort_order`
- Toggle visibility with active/inactive status
