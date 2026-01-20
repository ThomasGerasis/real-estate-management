<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\District;
use App\Models\Agent;
use App\Models\Property;
use App\Models\Post;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create Cities (update or create to avoid duplicates)
        $berlin = City::updateOrCreate(
            ['name' => 'Berlin', 'country' => 'Germany'],
            [
                'state' => 'Berlin',
                'postal_code' => '10115',
                'is_active' => true,
            ]
        );

        $munich = City::updateOrCreate(
            ['name' => 'Munich', 'country' => 'Germany'],
            [
                'state' => 'Bavaria',
                'postal_code' => '80331',
                'is_active' => true,
            ]
        );

        $hamburg = City::updateOrCreate(
            ['name' => 'Hamburg', 'country' => 'Germany'],
            [
                'state' => 'Hamburg',
                'postal_code' => '20095',
                'is_active' => true,
            ]
        );

        // Create Districts
        $mitte = District::updateOrCreate(
            ['city_id' => $berlin->id, 'name' => 'Mitte'],
            [
                'postal_code' => '10115',
                'is_active' => true,
            ]
        );

        $kreuzberg = District::updateOrCreate(
            ['city_id' => $berlin->id, 'name' => 'Kreuzberg'],
            [
                'postal_code' => '10965',
                'is_active' => true,
            ]
        );

        $altstadt = District::updateOrCreate(
            ['city_id' => $munich->id, 'name' => 'Altstadt-Lehel'],
            [
                'postal_code' => '80331',
                'is_active' => true,
            ]
        );

        // Create Agents
        $agent1 = Agent::updateOrCreate(
            ['name' => 'John Smith'],
            [
                'bio' => 'Experienced real estate agent with 10+ years in Berlin market.',
                'is_active' => true,
            ]
        );

        $agent2 = Agent::updateOrCreate(
            ['name' => 'Maria Schmidt'],
            [
                'bio' => 'Specializing in luxury properties in Munich.',
                'is_active' => true,
            ]
        );

        // Create Properties
        Property::updateOrCreate(
            ['address' => 'Friedrichstraße 123', 'postal_code' => '10115'],
            [
                'title' => 'Modern Apartment in Berlin Mitte',
                'description' => 'Beautiful modern apartment in the heart of Berlin. Recently renovated with high-quality finishes. Perfect for professionals or small families.',
                'agent_id' => $agent1->id,
                'city_id' => $berlin->id,
                'district_id' => $mitte->id,
                'price' => 450000,
                'status' => 'available',
                'type' => 'apartment',
                'listing_type' => 'sale',
                'bedrooms' => 2,
                'bathrooms' => 1,
                'square_meters' => 75.5,
                'year_built' => 2020,
                'energy_class' => 'A',
                'garage' => 1,
                'is_featured' => true,
                'published_at' => now(),
            ]
        );

        Property::updateOrCreate(
            ['address' => 'Maximilianstraße 45', 'postal_code' => '80539'],
            [
                'title' => 'Luxury Villa in Munich',
                'description' => 'Stunning luxury villa with garden and pool. Located in a quiet, prestigious neighborhood.',
                'agent_id' => $agent2->id,
                'city_id' => $munich->id,
                'district_id' => $altstadt->id,
                'price' => 1850000,
                'status' => 'available',
                'type' => 'house',
                'listing_type' => 'sale',
                'city_id' => $munich->id,
                'district_id' => $altstadt->id,
                'price' => 1850000,
                'status' => 'available',
                'type' => 'house',
                'bedrooms' => 5,
                'bathrooms' => 3,
                'square_meters' => 250.0,
                'year_built' => 2018,
                'energy_class' => 'B',
                'garage' => 2,
                'is_featured' => true,
                'published_at' => now(),
            ]
        );

        Property::updateOrCreate(
            ['address' => 'Oranienstraße 78', 'postal_code' => '10969'],
            [
                'title' => 'Cozy Studio in Kreuzberg - For Rent',
                'description' => 'Perfect for students or young professionals. Well-connected to public transport.',
                'agent_id' => $agent1->id,
                'city_id' => $berlin->id,
                'district_id' => $kreuzberg->id,
                'price' => 950,
                'status' => 'available',
                'type' => 'apartment',
                'listing_type' => 'rent',
                'bedrooms' => 1,
                'bathrooms' => 1,
                'square_meters' => 35.0,
                'year_built' => 2015,
                'energy_class' => 'C',
                'garage' => 0,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        Property::updateOrCreate(
            ['address' => 'Mönckebergstraße 11', 'postal_code' => '20095'],
            [
                'title' => 'Commercial Space in Hamburg',
                'description' => 'Prime commercial location perfect for retail or office use.',
                'agent_id' => $agent1->id,
                'city_id' => $hamburg->id,
                'price' => 650000,
                'status' => 'pending',
                'type' => 'commercial',
                'listing_type' => 'sale',
                'square_meters' => 120.0,
                'year_built' => 2010,
                'energy_class' => 'D',
                'garage' => 0,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        Property::updateOrCreate(
            ['address' => 'Leopoldstraße 99', 'postal_code' => '80802'],
            [
                'title' => 'Family Home Sold',
                'description' => 'Recently sold family home with garden.',
                'agent_id' => $agent2->id,
                'city_id' => $munich->id,
                'price' => 890000,
                'status' => 'sold',
                'type' => 'house',
                'listing_type' => 'sale',
                'bedrooms' => 4,
                'bathrooms' => 2,
                'square_meters' => 180.0,
                'year_built' => 2012,
                'energy_class' => 'B',
                'garage' => 2,
                'is_featured' => false,
                'published_at' => now()->subDays(30),
            ]
        );

        // Create Posts
        Post::updateOrCreate(
            ['slug' => 'real-estate-market-trends-2025'],
            [
                'title' => 'Real Estate Market Trends 2025',
                'excerpt' => 'Discover the latest trends in the German real estate market for 2025.',
                'content' => '<p>The German real estate market continues to show strong growth in 2025. Here are the key trends to watch...</p><p>Energy efficiency is becoming increasingly important, with properties rated A or B seeing significantly higher demand.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ]
        );

        Post::updateOrCreate(
            ['slug' => 'how-to-choose-right-energy-class'],
            [
                'title' => 'How to Choose the Right Energy Class',
                'excerpt' => 'Understanding energy classes and their impact on your property value.',
                'content' => '<p>Energy classes range from A+ (most efficient) to G (least efficient). When buying a property, the energy class can significantly impact your heating costs and resale value.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(10),
            ]
        );

        Post::updateOrCreate(
            ['slug' => 'investment-opportunities-berlin'],
            [
                'title' => 'Investment Opportunities in Berlin',
                'excerpt' => 'A draft article about investment opportunities.',
                'content' => '<p>This is a draft article that will be published soon...</p>',
                'status' => 'draft',
                'published_at' => null,
            ]
        );

        // Create Pages
        \App\Models\Page::updateOrCreate(
            ['slug' => 'about-us'],
            [
                'title' => 'About Us',
                'content' => '<h2>Welcome to Our Real Estate Agency</h2><p>We are a leading real estate agency in Germany, specializing in residential and commercial properties.</p><p>Our team of experienced agents is dedicated to helping you find your dream home or the perfect investment property.</p>',
                'excerpt' => 'Learn more about our real estate agency and our commitment to excellence.',
                'status' => 'published',
                'sort_order' => 1,
                'show_in_menu' => true,
                'published_at' => now(),
            ]
        );

        \App\Models\Page::updateOrCreate(
            ['slug' => 'contact'],
            [
                'title' => 'Contact Us',
                'content' => '<h2>Get in Touch</h2><p><strong>Office Address:</strong><br>Friedrichstraße 100<br>10117 Berlin, Germany</p><p><strong>Phone:</strong> +49 30 1234567<br><strong>Email:</strong> info@realestate.com</p><p><strong>Office Hours:</strong><br>Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM - 2:00 PM</p>',
                'excerpt' => 'Contact our team for any inquiries about properties or services.',
                'status' => 'published',
                'sort_order' => 2,
                'show_in_menu' => true,
                'published_at' => now(),
            ]
        );

        \App\Models\Page::updateOrCreate(
            ['slug' => 'services'],
            [
                'title' => 'Our Services',
                'content' => '<h2>What We Offer</h2><ul><li><strong>Property Sales:</strong> Helping you buy or sell residential and commercial properties</li><li><strong>Property Rentals:</strong> Find the perfect rental property</li><li><strong>Property Management:</strong> Complete property management services</li><li><strong>Investment Consulting:</strong> Expert advice on real estate investments</li><li><strong>Market Analysis:</strong> Detailed market reports and valuations</li></ul>',
                'excerpt' => 'Comprehensive real estate services tailored to your needs.',
                'status' => 'published',
                'sort_order' => 3,
                'show_in_menu' => true,
                'meta_title' => 'Real Estate Services - Sales, Rentals & Management',
                'meta_description' => 'Professional real estate services including property sales, rentals, management, and investment consulting in Germany.',
                'published_at' => now(),
            ]
        );

        echo "\n✅ Demo data seeded successfully!\n";
        echo "   - 3 Cities\n";
        echo "   - 3 Districts\n";
        echo "   - 2 Agents\n";
        echo "   - 5 Properties (2 for sale, 1 for rent, 1 sold, 1 pending)\n";
        echo "   - 3 Posts\n";
        echo "   - 3 Pages\n\n";
        echo "   - 5 Properties\n";
        echo "   - 3 Posts\n\n";
    }
}
