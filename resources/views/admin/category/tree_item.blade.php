<li class="dd-item dd3-item" data-id="{{ $category['id'] }}">
    <div class="dd-handle dd3-handle"></div>
    <div class="dd3-content">
        <a style="{{ $activeId === $category['id'] ? 'font-weight: bold' : ''}}" href="{{ route('admin.category.edit', ['id' => $category['id']]) }}">{{ $category['name'] }}</a>
    </div>

    @if (!empty($category['children']))
        <ol class="dd-list">
            @foreach ($category['children'] as $child)
                @include('admin.category.tree_item', ['category' => $child])
            @endforeach
        </ol>
    @endif
</li>
