<div class="faq-shortcode max-w-3xl mx-auto">
    @if($category)
        <h2 class="text-2xl font-bold mb-6">{{ $category }} FAQs</h2>
    @else
        <h2 class="text-2xl font-bold mb-6">Frequently Asked Questions</h2>
    @endif
    
    @if($faqs->count() > 0)
        <div class="space-y-4">
            @foreach($faqs as $faq)
                <div class="faq-item border border-gray-200 rounded-lg overflow-hidden">
                    <button type="button" 
                            onclick="this.nextElementSibling.classList.toggle('hidden')" 
                            class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition-colors flex justify-between items-center">
                        <span class="font-semibold text-gray-900">{{ $faq->question }}</span>
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="hidden px-6 py-4 bg-white">
                        <div class="prose max-w-none text-gray-700">
                            {!! $faq->answer !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">No FAQs available{{ $category ? ' in this category' : '' }}.</p>
    @endif
</div>
