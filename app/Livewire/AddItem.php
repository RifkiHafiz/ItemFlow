<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Item;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddItem extends Component
{
    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $description;

    #[Validate('required')]
    public $category_id;

    #[Validate('required')]
    public $status;

    #[Validate('required')]
    public $condition;

    #[Validate('required')]
    public $quantity_item;

    public function additem() {

        Item::create([
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'condition' => $this->condition,
            'quantity_item' => $this->quantity_item,
        ]);

        $this->reset(['name', 'description', 'category_id', 'status', 'condition', 'quantity_item']);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.add-item',[
            'categories' => Category::all(),
        ]);
    }
}
