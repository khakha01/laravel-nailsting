@extends('admin.layouts.layout')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#0c8fe1]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    Cây Danh Mục
                </h1>
                <p class="mt-2 text-sm text-gray-600">Xem cấu trúc phân cấp và quản lý danh mục theo dạng cây</p>
            </div>
            <a href="{{ route('categories.index') }}" 
                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                Xem Danh Sách
            </a>
        </div>

        {{-- Toolbar --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex flex-wrap items-center gap-3">
                {{-- Search --}}
                <div class="flex-1 min-w-[200px]">
                    <div class="relative">
                        <input type="text" id="tree-search" placeholder="Tìm kiếm danh mục..." 
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#0c8fe1] focus:border-transparent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                {{-- Actions --}}
                <button onclick="expandAll()" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Mở tất cả
                </button>
                <button onclick="collapseAll()" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                    </svg>
                    Đóng tất cả
                </button>
            </div>
        </div>

        {{-- Tree Container --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div id="category-tree" class="min-h-[400px]"></div>
        </div>

        {{-- Legend --}}
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="text-sm font-semibold text-blue-900 mb-2">💡 Hướng dẫn:</h3>
            <ul class="text-sm text-blue-800 space-y-1">
                <li>• <strong>Click vào danh mục</strong> để xem chi tiết</li>
                <li>• <strong>Chuột phải</strong> để mở menu: Sửa, Xóa, Thêm danh mục con</li>
                <li>• Danh mục <span class="line-through text-gray-400">gạch ngang</span> là danh mục đã tắt</li>
            </ul>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css" rel="stylesheet" />
<style>
    .jstree-default .jstree-anchor {
        font-size: 14px;
        padding: 4px 8px;
    }
    .jstree-default .jstree-clicked {
        background: #e0f2fe !important;
        border-radius: 4px;
    }
    .jstree-default .jstree-hovered {
        background: #f1f5f9 !important;
        border-radius: 4px;
    }
    #category-tree {
        font-family: inherit;
    }
    .vakata-context {
        border-radius: 8px;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }
</style>
@endpush

@push('scripts')
{{-- jQuery is required for jsTree --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>
<script>
// Declare treeInstance globally so expand/collapse functions can access it
let treeInstance = null;

document.addEventListener('DOMContentLoaded', function() {
    const tree = @json($categoriesTree);
    const treeData = tree.map(category => buildTreeNode(category));

    // Initialize jsTree
    $('#category-tree').jstree({
        'core': {
            'data': treeData,
            'check_callback': true,
            'themes': {
                'responsive': true,
                'dots': true
            }
        },
        'plugins': ['contextmenu', 'search'],
        'contextmenu': {
            'items': function(node) {
                return {
                    'view': {
                        'label': '👁️ Xem chi tiết',
                        'action': function() {
                            const categoryId = node.id.replace('category-', '');
                            window.location.href = '{{ route("categories.show", ":id") }}'.replace(':id', categoryId);
                        }
                    },
                    'edit': {
                        'label': '✏️ Sửa',
                        'action': function() {
                            const categoryId = node.id.replace('category-', '');
                            window.location.href = '{{ route("categories.show", ":id") }}'.replace(':id', categoryId);
                        }
                    },
                    'add': {
                        'label': '➕ Thêm danh mục con',
                        'action': function() {
                            const categoryId = node.id.replace('category-', '');
                            window.location.href = '{{ route("categories.create") }}?parent_id=' + categoryId;
                        }
                    },
                    'delete': {
                        'label': '🗑️ Xóa',
                        'action': function() {
                            const categoryId = node.id.replace('category-', '');
                            if (confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
                                // Create form and submit
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = '{{ route("categories.destroy", ":id") }}'.replace(':id', categoryId);
                                
                                const csrfToken = document.createElement('input');
                                csrfToken.type = 'hidden';
                                csrfToken.name = '_token';
                                csrfToken.value = '{{ csrf_token() }}';
                                
                                const methodField = document.createElement('input');
                                methodField.type = 'hidden';
                                methodField.name = '_method';
                                methodField.value = 'DELETE';
                                
                                form.appendChild(csrfToken);
                                form.appendChild(methodField);
                                document.body.appendChild(form);
                                form.submit();
                            }
                        }
                    }
                };
            }
        }
    }).on('ready.jstree', function() {
        // Store tree instance after it's fully initialized
        treeInstance = $('#category-tree').jstree(true);
        console.log('jsTree initialized successfully');
    });

    // Click handler - only navigate on LEFT click, not right-click
    $('#category-tree').on('select_node.jstree', function(e, data) {
        // Check if it's a left click (button 0) and not a right click (button 2)
        if (e.originalEvent && e.originalEvent.button !== 0) {
            return; // Don't navigate on right-click
        }
        
        const categoryId = data.node.id.replace('category-', '');
        window.location.href = '{{ route("categories.show", ":id") }}'.replace(':id', categoryId);
    });

    // Search functionality
    let searchTimeout;
    $('#tree-search').on('keyup', function() {
        clearTimeout(searchTimeout);
        const searchString = $(this).val();
        searchTimeout = setTimeout(function() {
            if (treeInstance) {
                treeInstance.search(searchString);
            }
        }, 250);
    });
});

function expandAll() {
    if (treeInstance) {
        treeInstance.open_all();
    }
}

function collapseAll() {
    if (treeInstance) {
        treeInstance.close_all();
    }
}

function buildTreeNode(category) {
    const statusBadge = category.is_active 
        ? '<span class="ml-2 px-2 py-0.5 text-xs bg-green-100 text-green-800 rounded">Hoạt động</span>'
        : '<span class="ml-2 px-2 py-0.5 text-xs bg-gray-100 text-gray-600 rounded">Đã tắt</span>';
    
    const textClass = category.is_active ? '' : 'line-through text-gray-400';
    
    return {
        'id': 'category-' + category.id,
        'text': `<span class="${textClass}"><strong>${category.name}</strong> ${statusBadge}</span><br>`,
        'children': category.children.map(child => buildTreeNode(child)),
        'state': {
            'opened': true
        }
    };
}
</script>
@endpush

@endsection
