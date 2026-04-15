<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class ContactController extends Controller
{
    #[OA\Post(
        path: '/contact',
        summary: 'Submit contact form',
        tags: ['Contact'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'surname', 'email', 'phone', 'message'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', maxLength: 255),
                    new OA\Property(property: 'surname', type: 'string', maxLength: 255),
                    new OA\Property(property: 'email', type: 'string', format: 'email'),
                    new OA\Property(property: 'phone', type: 'string'),
                    new OA\Property(property: 'message', type: 'string'),
                    new OA\Property(property: 'subject', type: 'string', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Message sent', content: new OA\JsonContent(ref: '#/components/schemas/SuccessMessage')),
            new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationError')),
        ]
    )]
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

    #[OA\Post(
        path: '/property-inquiry',
        summary: 'Submit property inquiry',
        tags: ['Contact'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'surname', 'email', 'phone', 'message'],
                properties: [
                    new OA\Property(property: 'property_id', type: 'integer', nullable: true),
                    new OA\Property(property: 'name', type: 'string'),
                    new OA\Property(property: 'surname', type: 'string'),
                    new OA\Property(property: 'email', type: 'string', format: 'email'),
                    new OA\Property(property: 'phone', type: 'string'),
                    new OA\Property(property: 'message', type: 'string'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Inquiry submitted', content: new OA\JsonContent(ref: '#/components/schemas/SuccessMessage')),
            new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationError')),
        ]
    )]
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

    #[OA\Post(
        path: '/inquiry',
        summary: 'Submit general property inquiry',
        tags: ['Contact'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'surname', 'email', 'phone', 'message'],
                properties: [
                    new OA\Property(property: 'name', type: 'string'),
                    new OA\Property(property: 'surname', type: 'string'),
                    new OA\Property(property: 'email', type: 'string', format: 'email'),
                    new OA\Property(property: 'phone', type: 'string'),
                    new OA\Property(property: 'message', type: 'string'),
                    new OA\Property(property: 'city_id', type: 'integer', nullable: true),
                    new OA\Property(property: 'listing_type', type: 'string', enum: ['sale', 'rent'], nullable: true),
                    new OA\Property(property: 'property_type', type: 'string', enum: ['house', 'apartment', 'commercial', 'land'], nullable: true),
                    new OA\Property(property: 'bedrooms', type: 'integer', nullable: true),
                    new OA\Property(property: 'min_price', type: 'number', nullable: true),
                    new OA\Property(property: 'max_price', type: 'number', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Inquiry submitted', content: new OA\JsonContent(ref: '#/components/schemas/SuccessMessage')),
            new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationError')),
        ]
    )]
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

    #[OA\Post(
        path: '/mandate',
        summary: 'Submit property mandate request',
        description: 'Used by property owners who want to sell or rent their property through the agency.',
        tags: ['Contact'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'surname', 'email', 'phone', 'message', 'city_id', 'listing_type', 'property_type', 'bedrooms', 'price', 'square_meters'],
                properties: [
                    new OA\Property(property: 'name', type: 'string'),
                    new OA\Property(property: 'surname', type: 'string'),
                    new OA\Property(property: 'email', type: 'string', format: 'email'),
                    new OA\Property(property: 'phone', type: 'string'),
                    new OA\Property(property: 'message', type: 'string'),
                    new OA\Property(property: 'city_id', type: 'integer'),
                    new OA\Property(property: 'listing_type', type: 'string', enum: ['sale', 'rent']),
                    new OA\Property(property: 'property_type', type: 'string', enum: ['house', 'apartment', 'commercial', 'land']),
                    new OA\Property(property: 'bedrooms', type: 'integer'),
                    new OA\Property(property: 'price', type: 'number'),
                    new OA\Property(property: 'square_meters', type: 'number'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Mandate submitted', content: new OA\JsonContent(ref: '#/components/schemas/SuccessMessage')),
            new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationError')),
        ]
    )]
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
