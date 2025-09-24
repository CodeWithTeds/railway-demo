<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Pos extends Component
{
    public $search = '';
    public $category = '';
    public $cart = [];
    public $total = 0;
    
    public function mount()
    {
        $this->cart = session()->get('pos_cart', []);
        $this->calculateTotal();
    }
    
    public function render()
    {
        $query = Product::query();
        
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        
        if ($this->category) {
            $query->where('category', $this->category);
        }
        
        $products = $query->get();
        $categories = Product::distinct('category')->pluck('category')->toArray();
        
        return view('livewire.admin.pos', [
            'products' => $products,
            'categories' => $categories
        ]);
    }
    
    public function addToCart($productId)
    {
        $product = Product::find($productId);
        
        if (!$product) {
            return;
        }
        
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            $this->cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1
            ];
        }
        
        session()->put('pos_cart', $this->cart);
        $this->calculateTotal();
    }
    
    public function removeFromCart($productId)
    {
        if (isset($this->cart[$productId])) {
            unset($this->cart[$productId]);
            session()->put('pos_cart', $this->cart);
            $this->calculateTotal();
        }
    }
    
    public function updateQuantity($productId, $quantity)
    {
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity'] = max(1, $quantity);
            session()->put('pos_cart', $this->cart);
            $this->calculateTotal();
        }
    }
    
    public function clearCart()
    {
        $this->cart = [];
        session()->forget('pos_cart');
        $this->total = 0;
    }
    
    private function calculateTotal()
    {
        $this->total = 0;
        foreach ($this->cart as $item) {
            $this->total += $item['price'] * $item['quantity'];
        }
    }
}