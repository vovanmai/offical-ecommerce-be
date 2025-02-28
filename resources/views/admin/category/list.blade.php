<div class="dd" id="nestable-category">
    <ol class="dd-list">
        @foreach ($items as $item)
            @include('admin.category.tree_item', ['category' => $item])
        @endforeach
    </ol>
</div>

@push('script')
    <script>
        let draggedItemId = null;

        // Lấy ID ngay khi bắt đầu kéo
        $(document).on('mousedown', '.dd-handle', function () {
            draggedItemId = $(this).closest('.dd-item').data('id');
            console.log("Đang kéo category có ID:", draggedItemId);
        });

        $('#nestable-category').nestable({
            maxDepth: 2
        }).on('change', function (e) {
            $('.dd-item').each(function () {
                let itemId = $(this).data('id');
                let parent = $(this).parent('.dd-list').parent('.dd-item');

                if (parent.length) {
                    let parentId = parent.data('id');
                    draggedItemId = itemId; // Cập nhật ID của item vừa được kéo
                    console.log(`Category ${itemId} đã được kéo vào Category ${parentId}`);
                }
            });
        });
    </script>
@endpush
