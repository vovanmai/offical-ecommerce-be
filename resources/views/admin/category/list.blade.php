<div class="dd" id="nestable-category">
    <ol class="dd-list">
        @foreach ($items as $item)
            @include('admin.category.tree_item', ['category' => $item, 'activeId' => $activeId ?? null])
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
            let updateCategoris = []

            var parentItem = $(`.dd-item[data-id=${draggedItemId}]`).parent().closest('.dd-item');
            const parentId = parentItem.data('id') ? parentItem.data('id') : null;
            var dd_items = $(`.dd-item[data-id="${draggedItemId}"]`).parent().children('.dd-item');

            dd_items.each(function() {
                updateCategoris.push($(this).data('id'))
            });

            $.ajax({
                data: { category_ids: updateCategoris, parent_id: parentId },
                type: 'POST',
                url: "/admin/categories/update-order",
                success: function(response)
                {
                    location.reload();
                },
                error: function(error) {
                    toastr.error("Máy chủ bị lỗi.", 'Lỗi')
                }
            });
        });
    </script>
@endpush
