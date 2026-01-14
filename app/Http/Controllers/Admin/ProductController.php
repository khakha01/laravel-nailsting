<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductUnitEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Queries\ListProducts\ListProductHandler;
use App\Queries\ListProducts\ListProductQuery;
use App\Services\Product\ProductService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected ListProductHandler $listProductHandler
    ) {}

     public function index(Request $request)
    {
        try {
        $isActive =  $request->filled('is_active') ? (int) $request->get('is_active') : null;
            $query = new ListProductQuery(
                search: $request->get('search'),
                categoryId: $request->get('category_id'),
                isActive: $isActive,
                page: $request->get('page', 1),
                perPage: (int) ($request->get('perPage', 15)),
            );

            $products = app(ListProductHandler::class)->execute($query);
            $categories = Category::orderBy('display_order')->get();

            return view('admin.product-management.index', compact('products', 'categories'));
        } catch (Exception $e) {
            return back()->with('error', 'Không thể lấy danh sách sản phẩm: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        try {
            $categories = Category::where('is_active', true)->orderBy('display_order')->get();
            $units = ProductUnitEnum::labels();
            return view('admin.product-management.create', compact('categories', 'units'));
        } catch (Exception $e) {
            return back()->with('error', 'Không thể mở form tạo sản phẩm: ' . $e->getMessage());
        }
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        try {
            $unit = ProductUnitEnum::from($request->string('unit'));

            $this->productService->createService(
                categoryId: $request->input('category_id'),
                name: $request->input('name'),
                code: $request->input('code') ?? null,
                slug: $request->input('slug') ,
                description: $request->input('description') ?? null,
                unit: $unit,
                isActive: $request->input('is_active'),
                displayOrder: $request->integer('display_order'),
                prices: $request->input('prices')
            );

            return redirect()->route('products.index')
                ->with('success', 'Tạo sản phẩm thành công');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Không thể tạo sản phẩm: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        try {
            $product->load('category', 'prices');
            return view('admin.product-management.show', compact('product'));
        } catch (Exception $e) {
            return back()->with('error', 'Không thể lấy thông tin sản phẩm: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified product
     */
    public function edit(Product $product)
    {
        try {
            $product->load('category', 'prices');
            $categories = Category::where('is_active', true)->orderBy('display_order')->get();
            $units = ProductUnitEnum::labels();
            return view('admin.product-management.edit', compact('product', 'categories', 'units'));
        } catch (Exception $e) {
            return back()->with('error', 'Không thể mở form sửa sản phẩm: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified product
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        try {
            $unit = ProductUnitEnum::from($request->string('unit'));

            $this->productService->updateService(
                id: $product->id,
                categoryId: $request->integer('category_id'),
                name: $request->string('name'),
                code: $request->string('code') ?? null,
                slug: $request->input('slug') ,
                description: $request->string('description') ?? null,
                unit: $unit,
                isActive: $request->boolean('is_active'),
                displayOrder: $request->integer('display_order'),
                prices: $request->input('prices')
            );

            return redirect()
                ->route('products.index')
                ->with('success', 'Cập nhật sản phẩm thành công');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Không thể cập nhật sản phẩm: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified product
     */
    public function destroy(Product $product): RedirectResponse
    {
        try {
            $this->productService->deleteService($product->id);
            return redirect()->route('products.index')
                ->with('success', 'Xóa sản phẩm thành công');
        } catch (Exception $e) {
            return back()->with('error', 'Không thể xóa sản phẩm: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete products
     */
    public function bulkDelete(Request $request): RedirectResponse
    {
        try {
            $productIds = $request->input('product_ids', []);
            if (empty($productIds)) {
                return back()->with('error', 'Vui lòng chọn sản phẩm để xóa');
            }

            $deleted = $this->productService->bulkDeleteService($productIds);
            return redirect()->route('products.index')
                ->with('success', "Đã xóa {$deleted} sản phẩm");
        } catch (Exception $e) {
            return back()->with('error', 'Không thể xóa sản phẩm: ' . $e->getMessage());
        }
    }

    /**
     * Get products by category (API endpoint)
     */
    public function byCategory(int $categoryId)
    {
        try {
            $products = $this->productService->getProductsByCategory($categoryId);
            return response()->json([
                'success' => true,
                'data' => $products
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
