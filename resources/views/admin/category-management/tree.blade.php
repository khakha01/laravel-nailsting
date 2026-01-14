@extends('admin.layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Cây Danh Mục</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                <i class="bi bi-list"></i> Xem Danh Sách
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div id="category-tree"></div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tree = @json($categoriesTree);

    const treeData = tree.map(category => buildTreeNode(category));

    $('#category-tree').jstree({
        'core' : {
            'data' : treeData
        }
    });

    function buildTreeNode(category) {
        return {
            'id': 'category-' + category.id,
            'text': `<strong>${category.name}</strong><br><small class="text-muted">${category.slug}</small>`,
            'children': category.children.map(child => buildTreeNode(child)),
            'a_attr': {
                'href': '{{ route("categories.show", ":id") }}'.replace(':id', category.id),
                'class': category.is_active ? '' : 'text-muted text-decoration-line-through'
            }
        };
    }
});
</script>
@endpush

@endsection
