<div class="mandate-form-shortcode max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">{{ $title }}</h2>

    <form action="{{ route('contact.mandate') }}" method="POST" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="man_name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                <input type="text"
                       id="man_name"
                       name="name"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="man_surname" class="block text-sm font-medium text-gray-700 mb-1">Surname *</label>
                <input type="text"
                       id="man_surname"
                       name="surname"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="man_email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email"
                       id="man_email"
                       name="email"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="man_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                <input type="tel"
                       id="man_phone"
                       name="phone"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="man_city" class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                <select id="man_city"
                        name="city_id"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select city</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="man_listing_type" class="block text-sm font-medium text-gray-700 mb-1">Purpose *</label>
                <select id="man_listing_type"
                        name="listing_type"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select</option>
                    <option value="sale">Sell</option>
                    <option value="rent">Rent Out</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="man_property_type" class="block text-sm font-medium text-gray-700 mb-1">Property Type *</label>
                <select id="man_property_type"
                        name="property_type"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select</option>
                    <option value="house">House</option>
                    <option value="apartment">Apartment</option>
                    <option value="commercial">Commercial</option>
                    <option value="land">Land</option>
                </select>
            </div>

            <div>
                <label for="man_bedrooms" class="block text-sm font-medium text-gray-700 mb-1">Bedrooms *</label>
                <input type="number"
                       id="man_bedrooms"
                       name="bedrooms"
                       required
                       min="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="man_price" class="block text-sm font-medium text-gray-700 mb-1">Asking Price (€) *</label>
                <input type="number"
                       id="man_price"
                       name="price"
                       required
                       min="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="man_sqm" class="block text-sm font-medium text-gray-700 mb-1">Size (m²) *</label>
                <input type="number"
                       id="man_sqm"
                       name="square_meters"
                       required
                       min="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div>
            <label for="man_message" class="block text-sm font-medium text-gray-700 mb-1">Additional Details *</label>
            <textarea id="man_message"
                      name="message"
                      required
                      rows="4"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <div>
            <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 px-6 rounded-md hover:bg-blue-700 transition-colors font-semibold">
                Submit Mandate Request
            </button>
        </div>
    </form>
</div>
