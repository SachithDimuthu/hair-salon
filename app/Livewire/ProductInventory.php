<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;

class ProductInventory extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $selectedCategory = '';
    public $stockFilter = '';
    public $sortBy = 'name';
    public $sortOrder = 'asc';
    
    // Product form properties
    public $showProductForm = false;
    public $editingProduct = null;

    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|string|max:255')]
    public $sku = '';

    #[Validate('nullable|string|max:500')]
    public $description = '';

    #[Validate('required|numeric|min:0')]
    public $price = '';

    #[Validate('required|numeric|min:0')]
    public $cost_price = '';

    #[Validate('required|integer|min:0')]
    public $quantity_on_hand = '';

    #[Validate('required|integer|min:0')]
    public $min_stock_level = '';

    #[Validate('nullable|exists:categories,id')]
    public $category_id = '';

    #[Validate('nullable|string|max:255')]
    public $brand = '';

    #[Validate('nullable|string|max:100')]
    public $size = '';

    public $is_active = true;

    public $categories = [];
    public $lowStockCount = 0;
    public $totalProducts = 0;
    public $totalValue = 0;

    public function mount()
    {
        $this->categories = Category::where('type', 'product')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        $this->calculateStats();
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function updatingStockFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortOrder = $this->sortOrder === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortOrder = 'asc';
        }
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['searchTerm', 'selectedCategory', 'stockFilter']);
        $this->resetPage();
    }

    public function showAddProductForm()
    {
        $this->resetProductForm();
        $this->showProductForm = true;
    }

    public function editProduct($productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $this->editingProduct = $product->id;
            $this->name = $product->name;
            $this->sku = $product->sku;
            $this->description = $product->description;
            $this->price = $product->price;
            $this->cost_price = $product->cost_price;
            $this->quantity_on_hand = $product->quantity_on_hand;
            $this->min_stock_level = $product->min_stock_level;
            $this->category_id = $product->category_id;
            $this->brand = $product->brand;
            $this->size = $product->size;
            $this->is_active = $product->is_active;
            $this->showProductForm = true;
        }
    }

    public function saveProduct()
    {
        $this->validate();

        if ($this->editingProduct) {
            // Update existing product
            $product = Product::find($this->editingProduct);
            $product->update([
                'name' => $this->name,
                'sku' => $this->sku,
                'description' => $this->description,
                'price' => $this->price,
                'cost_price' => $this->cost_price,
                'quantity_on_hand' => $this->quantity_on_hand,
                'min_stock_level' => $this->min_stock_level,
                'category_id' => $this->category_id ?: null,
                'brand' => $this->brand,
                'size' => $this->size,
                'is_active' => $this->is_active,
            ]);
            session()->flash('message', 'Product updated successfully!');
        } else {
            // Create new product
            Product::create([
                'name' => $this->name,
                'sku' => $this->sku,
                'description' => $this->description,
                'price' => $this->price,
                'cost_price' => $this->cost_price,
                'quantity_on_hand' => $this->quantity_on_hand,
                'min_stock_level' => $this->min_stock_level,
                'category_id' => $this->category_id ?: null,
                'brand' => $this->brand,
                'size' => $this->size,
                'is_active' => $this->is_active,
            ]);
            session()->flash('message', 'Product added successfully!');
        }

        $this->closeProductForm();
        $this->calculateStats();
    }

    public function deleteProduct($productId)
    {
        Product::find($productId)->delete();
        session()->flash('message', 'Product deleted successfully!');
        $this->calculateStats();
    }

    public function toggleStatus($productId)
    {
        $product = Product::find($productId);
        $product->update(['is_active' => !$product->is_active]);
        $status = $product->is_active ? 'activated' : 'deactivated';
        session()->flash('message', "Product {$status} successfully!");
    }

    public function adjustStock($productId, $adjustment)
    {
        $product = Product::find($productId);
        $newQuantity = max(0, $product->quantity_on_hand + $adjustment);
        $product->update(['quantity_on_hand' => $newQuantity]);
        
        $action = $adjustment > 0 ? 'increased' : 'decreased';
        session()->flash('message', "Stock {$action} for {$product->name}");
        $this->calculateStats();
    }

    public function closeProductForm()
    {
        $this->showProductForm = false;
        $this->resetProductForm();
    }

    public function resetProductForm()
    {
        $this->reset([
            'editingProduct',
            'name',
            'sku',
            'description',
            'price',
            'cost_price',
            'quantity_on_hand',
            'min_stock_level',
            'category_id',
            'brand',
            'size',
            'is_active'
        ]);
        $this->is_active = true;
    }

    public function calculateStats()
    {
        $this->totalProducts = Product::count();
        $this->lowStockCount = Product::whereRaw('quantity_on_hand <= min_stock_level')->count();
        $this->totalValue = Product::sum(DB::raw('quantity_on_hand * cost_price'));
    }

    public function getProductsProperty()
    {
        $query = Product::with('category')
            ->orderBy($this->sortBy, $this->sortOrder);

        // Apply search filter
        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('sku', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('brand', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Apply category filter
        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        // Apply stock filter
        if ($this->stockFilter === 'low') {
            $query->whereRaw('quantity_on_hand <= min_stock_level');
        } elseif ($this->stockFilter === 'out') {
            $query->where('quantity_on_hand', 0);
        } elseif ($this->stockFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->stockFilter === 'inactive') {
            $query->where('is_active', false);
        }

        return $query->paginate(15);
    }

    public function render()
    {
        return view('livewire.product-inventory', [
            'products' => $this->products,
        ]);
    }
}
