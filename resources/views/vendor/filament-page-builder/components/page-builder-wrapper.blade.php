<div>
    @if($page)
        @livewire('page-builder-editor', ['page' => $page, 'locale' => $locale], key('page-builder-' . $page->id . '-' . $locale))
    @else
        <div class="text-gray-500 text-center py-8">
            <p>Save the page first to start building.</p>
        </div>
    @endif
</div>
