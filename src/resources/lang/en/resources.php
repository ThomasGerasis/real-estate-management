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
            'publish_status' => 'Publish Status',
            'price' => 'Price',
            'agent' => 'Agent',
            'address' => 'Address',
            'city' => 'City',
            'district' => 'District',
            'subdistrict' => 'Subdistrict',
            'location_map' => 'Map Location',
            'area' => 'Area',
            'bedrooms' => 'Bedrooms',
            'bathrooms' => 'Bathrooms',
            'garage' => 'Garage (Spots)',
            'garage_type' => 'Garage Type',
            'elevator' => 'Elevator',
            'heating_type' => 'Heating',
            'heating_fuel' => 'Heating Fuel',
            'fireplace' => 'Fireplace',
            'furnished' => 'Furnished',
            'property_position' => 'Property Position',
            'property_condition' => 'Property Condition',
            'floor_type' => 'Floor Type',
            'floor' => 'Floor',
            'year_built' => 'Year Built',
            'images' => 'Images',
            'featured' => 'Featured',
            'published' => 'Published At',
        ],
        'heating_types' => [
            'central'    => 'Central',
            'autonomous' => 'Autonomous (Individual)',
            'none'       => 'No Heating',
        ],
        'heating_fuels' => [
            'gas'       => 'Natural Gas',
            'oil'       => 'Oil',
            'electric'  => 'Electric',
            'heat_pump' => 'Heat Pump',
            'other'     => 'Other',
        ],
        'property_positions' => [
            'front'    => 'Front-Facing',
            'interior' => 'Interior',
            'corner'   => 'Corner',
            'through'  => 'Through',
        ],
        'property_conditions' => [
            'new'              => 'New Build',
            'renovated'        => 'Renovated',
            'excellent'        => 'Excellent',
            'needs_renovation' => 'Needs Renovation',
        ],
        'garage_types' => [
            'open'        => 'Open',
            'pilotis'     => 'Pilotis',
            'underground' => 'Underground',
            'closed'      => 'Closed',
            'spots'       => 'Parking Spots',
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
        'publish_statuses' => [
            'draft' => 'Draft',
            'published' => 'Published',
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
            'image' => 'Image',
            'properties_count' => 'Properties Count',
        ],
    ],

    'district' => [
        'label' => 'District',
        'plural_label' => 'Districts',
        'fields' => [
            'name' => 'Name',
            'city' => 'City',
            'image' => 'Image',
            'properties_count' => 'Properties Count',
            'subdistricts_count' => 'Subdistricts Count',
        ],
    ],

    'subdistrict' => [
        'label' => 'Subdistrict',
        'plural_label' => 'Subdistricts',
        'fields' => [
            'name' => 'Name',
            'district' => 'District',
            'city' => 'City',
            'postal_code' => 'Postal Code',
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
