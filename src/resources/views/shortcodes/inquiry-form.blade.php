<div class="inquiry-form-shortcode max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">{{ $title }}</h2>

    <form action="{{ route('contact.inquiry') }}" method="POST" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="inq_name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                <input type="text"
                       id="inq_name"
                       name="name"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="inq_surname" class="block text-sm font-medium text-gray-700 mb-1">Surname *</label>
                <input type="text"
                       id="inq_surname"
                       name="surname"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="inq_email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email"
                       id="inq_email"
                       name="email"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="inq_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                <input type="tel"
                       id="inq_phone"
                       name="phone"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="inq_city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                <select id="inq_city"
                        name="city_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Any city</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ $defaultCityId == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="inq_listing_type" class="block text-sm font-medium text-gray-700 mb-1">Looking to</label>
                <select id="inq_listing_type"
                        name="listing_type"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Any</option>
                    <option value="sale" {{ $defaultListingType === 'sale' ? 'selected' : '' }}>Buy</option>
                    <option value="rent" {{ $defaultListingType === 'rent' ? 'selected' : '' }}>Rent</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="inq_property_type" class="block text-sm font-medium text-gray-700 mb-1">Property Type</label>
                <select id="inq_property_type"
                        name="property_type"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Any</option>
                    <option value="house" {{ $defaultPropertyType === 'house' ? 'selected' : '' }}>House</option>
                    <option value="apartment" {{ $defaultPropertyType === 'apartment' ? 'selected' : '' }}>Apartment</option>
                    <option value="commercial" {{ $defaultPropertyType === 'commercial' ? 'selected' : '' }}>Commercial</option>
                    <option value="land" {{ $defaultPropertyType === 'land' ? 'selected' : '' }}>Land</option>
                </select>
            </div>

            <div>
                <label for="inq_bedrooms" class="block text-sm font-medium text-gray-700 mb-1">Bedrooms</label>
                <input type="number"
                       id="inq_bedrooms"
                       name="bedrooms"
                       min="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="inq_min_price" class="block text-sm font-medium text-gray-700 mb-1">Min Price (€)</label>
                <input type="number"
                       id="inq_min_price"
                       name="min_price"
                       min="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="inq_max_price" class="block text-sm font-medium text-gray-700 mb-1">Max Price (€)</label>
                <input type="number"
                       id="inq_max_price"
                       name="max_price"
                       min="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div>
            <label for="inq_message" class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
            <textarea id="inq_message"
                      name="message"
                      required
                      rows="4"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <div>
            <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 px-6 rounded-md hover:bg-blue-700 transition-colors font-semibold">
                Submit Inquiry
            </button>
        </div>
    </form>
</div>
