<?php

return [
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
            'postal_code' => 'Τ.Κ.',
            'agent' => 'Μεσίτης',
            'address' => 'Διεύθυνση',
            'city' => 'Πόλη',
            'district' => 'Περιοχή',
            'subdistrict' => 'Υποπεριοχή',
            'location_map' => 'Τοποθεσία στον Χάρτη',
            'area' => 'Εμβαδόν',
            'bedrooms' => 'Υπνοδωμάτια',
            'bathrooms' => 'Μπάνια',
            'garage' => 'Γκαράζ (Θέσεις)',
            'garage_type' => 'Τύπος Γκαράζ',
            'elevator' => 'Ασανσέρ',
            'heating_type' => 'Θέρμανση',
            'heating_fuel' => 'Είδος Θέρμανσης',
            'fireplace' => 'Τζάκι',
            'furnished' => 'Επιπλωμένο',
            'property_position' => 'Θέση Ακινήτου',
            'property_condition' => 'Κατάσταση Ακινήτου',
            'floor_type' => 'Είδος Πατώματος',
            'year_built' => 'Έτος Κατασκευής',
            'images' => 'Εικόνες',
            'featured' => 'Επιλεγμένο',
            'published' => 'Ημερομηνία Δημοσίευσης',
        ],
        'heating_types' => [
            'central'    => 'Κεντρική',
            'autonomous' => 'Αυτόνομη με Ατομική Εγκατάσταση',
            'none'       => 'Χωρίς Θέρμανση',
        ],
        'heating_fuels' => [
            'gas'       => 'Φυσικό Αέριο',
            'oil'       => 'Πετρέλαιο',
            'electric'  => 'Ηλεκτρικό Ρεύμα',
            'heat_pump' => 'Αντλία Θερμότητας',
            'other'     => 'Άλλο',
        ],
        'property_positions' => [
            'front'    => 'Προσόψεως',
            'interior' => 'Εσωτερικό',
            'corner'   => 'Γωνιακό',
            'through'  => 'Διαμπερές',
        ],
        'property_conditions' => [
            'new'              => 'Νεόδμητο',
            'renovated'        => 'Ανακαινισμένο',
            'excellent'        => 'Άριστη',
            'needs_renovation' => 'Χρήζει Ανακαίνιση',
        ],
        'garage_types' => [
            'open'        => 'Ανοιχτό',
            'pilotis'     => 'Πιλωτής',
            'underground' => 'Υπόγειο',
            'closed'      => 'Κλειστό',
            'spots'       => 'Θέσεις',
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
            'image' => 'Εικόνα',
            'properties_count' => 'Αριθμός Ακινήτων',
        ],
    ],

    'district' => [
        'label' => 'Περιοχή',
        'plural_label' => 'Περιοχές',
        'fields' => [
            'name' => 'Όνομα',
            'city' => 'Πόλη',
            'image' => 'Εικόνα',
            'properties_count' => 'Αριθμός Ακινήτων',
            'subdistricts_count' => 'Αριθμός Υποπεριοχών',
        ],
    ],

    'subdistrict' => [
        'label' => 'Υποπεριοχή',
        'plural_label' => 'Υποπεριοχές',
        'fields' => [
            'name' => 'Όνομα',
            'district' => 'Περιοχή',
            'city' => 'Πόλη',
            'postal_code' => 'Τ.Κ.',
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
