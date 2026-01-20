<?php

return [
    // Navigation Groups
    'navigation_groups' => [
        'properties' => 'Ακίνητα',
        'content' => 'Περιεχόμενο',
        'users' => 'Χρήστες',
        'settings' => 'Ρυθμίσεις',
    ],

    // Property Resource
    'property' => [
        'label' => 'Ακίνητο',
        'plural_label' => 'Ακίνητα',

        'sections' => [
            'basic_information' => 'Βασικές Πληροφορίες',
            'location' => 'Τοποθεσία',
            'pricing' => 'Τιμολόγηση',
            'features' => 'Χαρακτηριστικά',
            'images' => 'Εικόνες',
            'agent_information' => 'Πληροφορίες Μεσίτη',
            'additional_information' => 'Επιπλέον Πληροφορίες',
        ],

        'fields' => [
            'title' => 'Τίτλος',
            'description' => 'Περιγραφή',
            'type' => 'Τύπος',
            'listing_type' => 'Τύπος Καταχώρησης',
            'status' => 'Κατάσταση',
            'price' => 'Τιμή',
            'bedrooms' => 'Υπνοδωμάτια',
            'bathrooms' => 'Μπάνια',
            'energy_class' => 'Ενεργειακή Κλάση',
            'area' => 'Εμβαδόν',
            'year_built' => 'Έτος Κατασκευής',
            'address' => 'Διεύθυνση',
            'city' => 'Πόλη',
            'district' => 'Περιοχή',
            'postal_code' => 'Ταχυδρομικός Κώδικας',
            'latitude' => 'Γεωγραφικό Πλάτος',
            'longitude' => 'Γεωγραφικό Μήκος',
            'agent' => 'Μεσίτης',
            'featured' => 'Προτεινόμενο',
            'published' => 'Δημοσιευμένο',
            'views' => 'Προβολές',
            'images' => 'Εικόνες',
        ],

        'types' => [
            'house' => 'Μονοκατοικία',
            'apartment' => 'Διαμέρισμα',
            'commercial' => 'Επαγγελματικός Χώρος',
            'land' => 'Οικόπεδο',
        ],

        'listing_types' => [
            'sale' => 'Προς Πώληση',
            'rent' => 'Προς Ενοικίαση',
        ],

        'statuses' => [
            'available' => 'Διαθέσιμο',
            'pending' => 'Σε Εκκρεμότητα',
            'sold' => 'Πωλήθηκε',
            'rented' => 'Ενοικιάστηκε',
        ],
    ],

    // City Resource
    'city' => [
        'label' => 'Πόλη',
        'plural_label' => 'Πόλεις',

        'fields' => [
            'name' => 'Όνομα',
            'slug' => 'Slug',
            'properties_count' => 'Αριθμός Ακινήτων',
        ],
    ],

    // District Resource
    'district' => [
        'label' => 'Περιοχή',
        'plural_label' => 'Περιοχές',

        'fields' => [
            'name' => 'Όνομα',
            'slug' => 'Slug',
            'city' => 'Πόλη',
            'properties_count' => 'Αριθμός Ακινήτων',
        ],
    ],

    // Agent Resource
    'agent' => [
        'label' => 'Μεσίτης',
        'plural_label' => 'Μεσίτες',

        'fields' => [
            'name' => 'Όνομα',
            'email' => 'Email',
            'phone' => 'Τηλέφωνο',
            'bio' => 'Βιογραφικό',
            'photo' => 'Φωτογραφία',
            'properties_count' => 'Αριθμός Ακινήτων',
        ],
    ],

    // Post Resource
    'post' => [
        'label' => 'Άρθρο',
        'plural_label' => 'Άρθρα',

        'fields' => [
            'title' => 'Τίτλος',
            'slug' => 'Slug',
            'content' => 'Περιεχόμενο',
            'excerpt' => 'Περίληψη',
            'featured_image' => 'Κύρια Εικόνα',
            'published_at' => 'Ημερομηνία Δημοσίευσης',
            'author' => 'Συγγραφέας',
            'status' => 'Κατάσταση',
        ],

        'statuses' => [
            'draft' => 'Πρόχειρο',
            'published' => 'Δημοσιευμένο',
        ],
    ],

    // Page Resource
    'page' => [
        'label' => 'Σελίδα',
        'plural_label' => 'Σελίδες',

        'fields' => [
            'title' => 'Τίτλος',
            'slug' => 'Slug',
            'content' => 'Περιεχόμενο',
            'published' => 'Δημοσιευμένο',
        ],
    ],

    // Menu Resource
    'menu' => [
        'label' => 'Μενού',
        'plural_label' => 'Μενού',

        'fields' => [
            'name' => 'Όνομα',
            'slug' => 'Slug',
            'items' => 'Στοιχεία',
        ],
    ],
];
