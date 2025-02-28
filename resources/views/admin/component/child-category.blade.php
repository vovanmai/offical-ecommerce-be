<div>
    <div class="category" style="display: flex;align-items: center;">
        <input class="radio" type="checkbox" @if((old('category_id') ?? null) == $item['id']) checked @endif value="{{ $item['id'] }}" name="category_id" style="width: 18px;height: 18px;">
        <span style="margin-left: 10px">{{ $item['name'] }}</span>
    </div>

    @if(!empty($item['children']))
        <div style="margin-left: 30px;">
            @foreach($item['children'] as $item)
                @include('admin.component.child-category', ['item' => $item])
            @endforeach
        </div>
    @endif
</div>
