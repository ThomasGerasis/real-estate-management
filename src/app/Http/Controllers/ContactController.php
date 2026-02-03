<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    /**
     * 1. General contact form (contact page)
     * POST /api/v1/contact
     */
    public function submit(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'message' => 'required|string',
            'subject' => 'nullable|string|max:255',
        ]);

        $contact = Contact::create([
            ...$validated,
            'type' => 'contact',
        ]);

        return response()->json([
            'message' => 'Thank you for contacting us! We will get back to you soon.',
            'success' => true,
        ], 201);
    }

    /**
     * 2. Property inquiry form (specific property interest)
     * POST /api/v1/property-inquiry
     */
    public function submitPropertyInquiry(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'property_id' => 'nullable|exists:properties,id',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $contact = Contact::create([
            ...$validated,
            'type' => 'property_inquiry',
            'subject' => 'Property Inquiry' . ($validated['property_id'] ? ' - Property #' . $validated['property_id'] : ''),
        ]);

        return response()->json([
            'message' => 'Thank you for your inquiry! We will get back to you soon about this property.',
            'success' => true,
        ], 201);
    }

    /**
     * 3. General inquiry form (looking for properties with preferences)
     * POST /api/v1/inquiry
     */
    public function submitGeneralInquiry(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'message' => 'required|string',
            'city_id' => 'nullable|exists:cities,id',
            'listing_type' => 'nullable|string|in:sale,rent',
            'property_type' => 'nullable|string|in:house,apartment,commercial,land',
            'bedrooms' => 'nullable|integer|min:0',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
        ]);

        $contact = Contact::create([
            ...$validated,
            'type' => 'general_inquiry',
            'subject' => 'General Property Inquiry',
        ]);

        return response()->json([
            'message' => 'Thank you for your inquiry! We will help you find the perfect property.',
            'success' => true,
        ], 201);
    }

    /**
     * 4. Mandate form (request to sell/rent your property)
     * POST /api/v1/mandate
     */
    public function submitMandate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'message' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'listing_type' => 'required|string|in:sale,rent',
            'property_type' => 'required|string|in:house,apartment,commercial,land',
            'bedrooms' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'square_meters' => 'required|numeric|min:0',
        ]);

        $contact = Contact::create([
            ...$validated,
            'type' => 'mandate',
            'subject' => 'Property Mandate Request - ' . ucfirst($validated['listing_type']),
        ]);

        return response()->json([
            'message' => 'Thank you for your mandate request! Our team will contact you shortly to discuss your property.',
            'success' => true,
        ], 201);
    }
}

