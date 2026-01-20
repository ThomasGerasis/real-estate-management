<?php

return [
    // Navigation Groups
    'navigation_groups' => [
        'properties' => 'Properties',
        'content' => 'Content',
        'users' => 'Users',
        'settings' => 'Settings',
    ],

    // Property Resource
    'property' => [
        'label' => 'Property',
        'plural_label' => 'Properties',

        'sections' => [
            'basic_information' => 'Basic Information',
            'location' => 'Location',
            'pricing' => 'Pricing',
            'features' => 'Features',
            'images' => 'Images',
            'agent_information' => 'Agent Information',
            'additional_information' => 'Additional Information',
        ],

        'fields' => [
            'title' => 'Title',
            'description' => 'Description',
            'type' => 'Type',
            'listing_type' => 'Listing Type',
            'status' => 'Status',
            'price' => 'Price',
            'bedrooms' => 'Bedrooms',
            'bathrooms' => 'Bathrooms',
            'area' => 'Area',
            'year_built' => 'Year Built',
            'energy_class' => 'Energy Class',
            'address' => 'Address',
            'city' => 'City',
            'district' => 'District',
            'postal_code' => 'Postal Code',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'agent' => 'Agent',
            'featured' => 'Featured',
            'published' => 'Published',
            'views' => 'Views',
            'images' => 'Images',
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
            'pending' => 'Pending',
            'sold' => 'Sold',
            'rented' => 'Rented',
        ],
    ],

    // City Resource
    'city' => [
        'label' => 'City',
        'plural_label' => 'Cities',

        'fields' => [
            'name' => 'Name',
            'slug' => 'Slug',
            'properties_count' => 'Properties Count',
        ],
    ],

    // District Resource
    'district' => [
        'label' => 'District',
        'plural_label' => 'Districts',

        'fields' => [
            'name' => 'Name',
            'slug' => 'Slug',
            'city' => 'City',
            'properties_count' => 'Properties Count',
        ],
    ],

    // Agent Resource
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

    // Post Resource
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

    // Page Resource
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

    // Menu Resource
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
