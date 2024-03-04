<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\InventoryItem;

class InventoryItemController extends Controller
{
    public function index($_id = 0, Request $request){
        $searchQuery = $request->query('search'); 
        $query = InventoryItem::query();
        if ($searchQuery) {
            $query->where('name', 'like', '%' . $searchQuery . '%')
            ->orWhere('description', 'like', '%' . $searchQuery . '%')
            ->orWhere('price', 'like', '%' . $searchQuery . '%')
            ->orWhere('quantity', 'like', '%' . $searchQuery . '%');
        }
        if ($_id > 0) {
            $query->where('id', $_id);
        }
        $info = $query->get();
        return response()->json($info);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'quantity' => 'nullable|string|max:255',
            'price' => 'required|numeric', 
        ]);
        
        $data = $request->only('id', 'name', 'description', 'quantity', 'price');

        $newId = $data['id'];
        if (empty($data['id'])) {
            $inventoryitem = InventoryItem::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'quantity' => $data['quantity'],
                'price' => $data['price']
            ]);
        $newId = $inventoryitem->id;
        } else {
            $inventoryitem = InventoryItem::findOrFail($data['id']);
            $inventoryitem->update([
                'name' => $data['name'],
                'description' => $data['description'],
                'quantity' => $data['quantity'],
                'price' => $data['price']
            ]);
        }
        return response()->json($inventoryitem, 201);
    }

    public function destroy($id){
        $inventoryitem = InventoryItem::findOrFail($id);
        $inventoryitem->delete();
        return response()->json(['message' => 'Inventory item deleted successfully'], 200);
    }

    public function destroyAll(){
        InventoryItem::query()->delete();  
        return response()->json(['message' => 'All items have been deleted successfully'], 200);
    }
}
