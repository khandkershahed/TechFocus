<option value="{{ $category->id }}"
    @if(isset($selectedParent) && $selectedParent == $category->id) selected @endif>
    {{ str_repeat('— ', $level) }} {{ $category->name }}
</option>

@if ($category->children && count($category->children))
    @foreach ($category->children as $child)
        @include('admin.pages.category.partial.parent_option', [
            'category' => $child,
            'level' => $level + 1,               {{-- increment for children --}}
            'selectedParent' => $selectedParent ?? null
        ])
    @endforeach
@endif
