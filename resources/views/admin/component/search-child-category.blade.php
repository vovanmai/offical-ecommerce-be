<div>
    <div style="display: flex;align-items: center;">
        <input class="radio" type="checkbox" @if(in_array($category->id, $categoryIds ?? [])) checked @endif value="{{ $category->id }}" name="category_ids[]" style="width: 18px;height: 18px;">
        <span style="margin-left: 10px">{{ $category->title }}</span>
    </div>

    @if($category->childrenRecursive->isNotEmpty())
    <div style="margin-left: 15px;">
        @foreach($category->childrenRecursive as $category)
            @include('admin.component.search-child-category', ['category' => $category])
        @endforeach
    </div>
    @endif
</div>
