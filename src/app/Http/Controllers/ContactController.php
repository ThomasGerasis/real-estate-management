<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function submit(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|max:255',
            'subject' => 'nullable|max:255',
            'message' => 'required',
        ]);

        $contact = Contact::create([
            ...$validated,
            'type' => 'contact',
        ]);

        return response()->json([
            'data' => [
                'id' => $contact->id,
                'message' => 'Thank you for contacting us! We will get back to you soon.',
                'success' => true,
            ]
        ], 201);
    }

    public function submitPropertyInquiry(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|max:255',
            'subject' => 'nullable|max:255',
            'message' => 'required',
        ]);

        $contact = Contact::create([
            ...$validated,
            'type' => 'property_inquiry',
        ]);

        return response()->json([
            'data' => [
                'id' => $contact->id,
                'message' => 'Thank you for your inquiry! We will get back to you soon about this property.',
                'success' => true,
            ]
        ], 201);
    }
}

