<div class="property-inquiry-form-shortcode max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">{{ $title }}</h2>

    <form action="{{ route('contact.property-inquiry') }}" method="POST" class="space-y-4">
        @csrf
        @if($propertyId)
            <input type="hidden" name="property_id" value="{{ $propertyId }}">
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="pi_name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                <input type="text"
                       id="pi_name"
                       name="name"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="pi_surname" class="block text-sm font-medium text-gray-700 mb-1">Surname *</label>
                <input type="text"
                       id="pi_surname"
                       name="surname"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="pi_email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email"
                       id="pi_email"
                       name="email"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="pi_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                <input type="tel"
                       id="pi_phone"
                       name="phone"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div>
            <label for="pi_message" class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
            <textarea id="pi_message"
                      name="message"
                      required
                      rows="5"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <div>
            <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 px-6 rounded-md hover:bg-blue-700 transition-colors font-semibold">
                Send Inquiry
            </button>
        </div>
    </form>
</div>
