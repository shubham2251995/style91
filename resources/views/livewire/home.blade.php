<x-layouts.app>
<div class="w-full">
    @foreach($sections as $section)
            <div wire:key="section-{{ $section->id }}">
                @if($section->type === 'hero')
                    @include('components.sections.hero', ['section' => $section])
                
                @elseif($section->type === 'flash_sale')
                    @include('components.sections.flash-sale', ['section' => $section])
                
                @elseif($section->type === 'featured_collection')
                    @include('components.sections.featured-collection', ['section' => $section])
                
                @elseif($section->type === 'deal_of_day')
                    @include('components.sections.deal-of-day', ['section' => $section])
                
                @elseif($section->type === 'trending')
                    @include('components.sections.trending', ['section' => $section])
                
                @elseif($section->type === 'limited_stock')
                    @include('components.sections.limited-stock', ['section' => $section])
                
                @elseif($section->type === 'category_showcase')
                    @include('components.sections.category-showcase', ['section' => $section])
                
                @elseif($section->type === 'coupon_banner')
                    @include('components.sections.coupon-banner', ['section' => $section])
                
                @elseif($section->type === 'testimonials')
                    @include('components.sections.testimonials', ['section' => $section])
                
                @elseif($section->type === 'newsletter')
                    @include('components.sections.newsletter', ['section' => $section])

                @elseif($section->type === 'banner')
                    @include('components.sections.banner', ['content' => $section->content])

                @elseif($section->type === 'categories')
                    @include('components.sections.categories', ['content' => $section->content, 'title' => $section->title])

                @elseif($section->type === 'featured_products')
                    @include('components.sections.featured-products', ['content' => $section->content, 'title' => $section->title])
                @endif
            </div>
        @endforeach
    </div>
</x-layouts.app>
