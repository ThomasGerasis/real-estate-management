<div class="properties-shortcode">
    @if($properties->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($properties as $property)
                <div class="property-card border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    @if($property->images && count($property->images) > 0)
                        <img src="{{ asset('storage/' . $property->images[0]) }}" 
                             alt="{{ $property->title }}" 
                             class="w-full h-48 object-cover">
                    @endif
                    
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">{{ $property->title }}</h3>
                        
                        <div class="flex items-center gap-2 mb-2">
                            <span class="badge bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                {{ ucfirst($property->type) }}
                            </span>
                            <span class="badge bg-green-100 text-green-800 px-2 py-1 rounded text-sm">
                                {{ ucfirst($property->listing_type) }}
                            </span>
                        </div>
                        
                        @if($property->city)
                            <p class="text-gray-600 text-sm mb-2">
                                <i class="fas fa-map-marker-alt"></i> {{ $property->city->name }}
                            </p>
                        @endif
                        
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-2xl font-bold text-blue-600">
                                €{{ number_format($property->price, 0) }}
                                @if($property->listing_type === 'rent')<span class="text-sm">/mo</span>@endif
                            </span>
                        </div>
                        
                        <div class="flex gap-4 text-sm text-gray-600 mb-3">
                            @if($property->bedrooms)
                                <span><i class="fas fa-bed"></i> {{ $property->bedrooms }} bed</span>
                            @endif
                            @if($property->bathrooms)
                                <span><i class="fas fa-bath"></i> {{ $property->bathrooms }} bath</span>
                            @endif
                            @if($property->square_meters)
                                <span><i class="fas fa-ruler-combined"></i> {{ $property->square_meters }}m²</span>
                            @endif
                        </div>
                        
                        <a href="{{ $property->frontend_url }}" 
                           class="block w-full text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition-colors">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">No properties found.</p>
    @endif
</div>
