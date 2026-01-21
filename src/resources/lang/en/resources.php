<?php

return [
    'property' => [
        'label' => 'Property',
        'plural_label' => 'Properties',
        'sections' => [
            'basic_information' => 'Basic Information',
            'location' => 'Location',
            'features' => 'Features',
            'additional_information' => 'Additional Information',
            'images' => 'Images',
        ],
        'fields' => [
            'title' => 'Title',
            'description' => 'Description',
            'type' => 'Type',
            'listing_type' => 'Listing Type',
            'status' => 'Status',
            'price' => 'Price',
            'agent' => 'Agent',
            'address' => 'Address',
            'city' => 'City',
            'district' => 'District',
            'postal_code' => 'Postal Code',
            'area' => 'Area',
            'bedrooms' => 'Bedrooms',
            'bathrooms' => 'Bathrooms',
            'garage' => 'Garage',
            'year_built' => 'Year Built',
            'images' => 'Images',
            'featured' => 'Featured',
            'published' => 'Published At',
        ],
        'types' => [
            'house' => 'House',
            'apartment' => 'Apartment',
            'commercial' => 'Commercial',
            'land' => 'Land',
        ],
        'listing_types' => [
            'sale' => 'For Sale',
            'rent' => 'For Rent',
        ],
        'statuses' => [
            'available' => 'Available',
            'sold' => 'Sold',
            'rented' => 'Rented',
            'pending' => 'Pending',
        ],
    ],

    'agent' => [
        'label' => 'Agent',
        'plural_label' => 'Agents',
        'fields' => [
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'bio' => 'Bio',
            'photo' => 'Photo',
            'properties_count' => 'Properties Count',
        ],
    ],

    'city' => [
        'label' => 'City',
        'plural_label' => 'Cities',
        'fields' => [
            'name' => 'Name',
            'slug' => 'Slug',
            'properties_count' => 'Properties Count',
        ],
    ],

    'district' => [
        'label' => 'District',
        'plural_label' => 'Districts',
        'fields' => [
            'name' => 'Name',
            'city' => 'City',
            'properties_count' => 'Properties Count',
        ],
    ],

    'post' => [
        'label' => 'Post',
        'plural_label' => 'Posts',
        'fields' => [
            'title' => 'Title',
            'slug' => 'Slug',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'featured_image' => 'Featured Image',
            'published_at' => 'Published At',
            'author' => 'Author',
            'status' => 'Status',
        ],
        'statuses' => [
            'draft' => 'Draft',
            'published' => 'Published',
        ],
    ],

    'page' => [
        'label' => 'Page',
        'plural_label' => 'Pages',
        'fields' => [
            'title' => 'Title',
            'slug' => 'Slug',
            'content' => 'Content',
            'published' => 'Published',
        ],
    ],

    'menu' => [
        'label' => 'Menu',
        'plural_label' => 'Menus',
        'fields' => [
            'name' => 'Name',
            'slug' => 'Slug',
            'items' => 'Items',
        ],
    ],
];
