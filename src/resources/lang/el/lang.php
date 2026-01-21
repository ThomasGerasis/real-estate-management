<?php

return [
    'navigation_groups' => [
        'properties' => 'Ακίνητα',
        'content' => 'Περιεχόμενο',
        'users' => 'Χρήστες',
        'settings' => 'Ρυθμίσεις',
    ],

    'property' => [
        'label' => 'Ακίνητο',
        'plural_label' => 'Ακίνητα',
        'sections' => [
            'basic_information' => 'Βασικές Πληροφορίες',
            'location' => 'Τοποθεσία',
            'features' => 'Χαρακτηριστικά',
            'additional_information' => 'Επιπλέον Πληροφορίες',
            'images' => 'Εικόνες',
        ],
        'fields' => [
            'title' => 'Τίτλος',
            'description' => 'Περιγραφή',
            'type' => 'Τύπος',
            'listing_type' => 'Τύπος Καταχώρησης',
            'status' => 'Κατάσταση',
            'price' => 'Τιμή',
            'agent' => 'Μεσίτης',
            'address' => 'Διεύθυνση',
            'city' => 'Πόλη',
            'district' => 'Περιοχή',
            'postal_code' => 'Τ.Κ.',
            'area' => 'Εμβαδόν',
            'bedrooms' => 'Υπνοδωμάτια',
            'bathrooms' => 'Μπάνια',
            'garage' => 'Γκαράζ',
            'year_built' => 'Έτος Κατασκευής',
            'images' => 'Εικόνες',
            'featured' => 'Επιλεγμένο',
            'published' => 'Ημερομηνία Δημοσίευσης',
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
            'sold' => 'Πωλήθηκε',
            'rented' => 'Ενοικιάστηκε',
            'pending' => 'Σε Εκκρεμότητα',
        ],
    ],

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

    'city' => [
        'label' => 'Πόλη',
        'plural_label' => 'Πόλεις',
        'fields' => [
            'name' => 'Όνομα',
            'slug' => 'Slug',
            'properties_count' => 'Αριθμός Ακινήτων',
        ],
    ],

    'district' => [
        'label' => 'Περιοχή',
        'plural_label' => 'Περιοχές',
        'fields' => [
            'name' => 'Όνομα',
            'city' => 'Πόλη',
            'properties_count' => 'Αριθμός Ακινήτων',
        ],
    ],

    'post' => [
        'label' => 'Άρθρο',
        'plural_label' => 'Άρθρα',
        'fields' => [
            'title' => 'Τίτλος',
            'slug' => 'Slug',
            'content' => 'Περιεχόμενο',
            'excerpt' => 'Απόσπασμα',
            'featured_image' => 'Εικόνα',
            'published_at' => 'Ημερομηνία Δημοσίευσης',
            'author' => 'Συγγραφέας',
            'status' => 'Κατάσταση',
        ],
        'statuses' => [
            'draft' => 'Πρόχειρο',
            'published' => 'Δημοσιευμένο',
        ],
    ],

    'page' => [
        'label' => 'Σελίδα',
        'plural_label' => 'Σελίδες',
        'fields' => [
            'title' => 'Τίτλος',
            'slug' => 'Slug',
            'content' => 'Περιεχόμενο',
            'published' => 'Δημοσιεύτηκε',
        ],
    ],

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
