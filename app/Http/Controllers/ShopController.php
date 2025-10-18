<?php
namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $shops = auth()->user()->hasRole('owner') ? Shop::where('owner_id', auth()->id())->get() : Shop::all();
        return view('shops.index', compact('shops'));
    }

    public function store(Request $request)
    {
        $request->validate(['name'=>'required','location'=>'nullable']);
        Shop::create(['name'=>$request->name,'location'=>$request->location,'owner_id'=>auth()->id()]);
        return back()->with('success','Shop created');
    }

    public function edit(Shop $shop){
        $this->authorizeAction($shop);
        return view('shops.edit', compact('shop'));
    }

    public function update(Request $request, Shop $shop){
        $this->authorizeAction($shop);
        $request->validate(['name'=>'required','location'=>'nullable']);
        $shop->update($request->only('name','location'));
        return redirect()->route('shops.index')->with('success','Shop updated');
    }

    public function destroy(Shop $shop){
        $this->authorizeAction($shop);
        $shop->delete();
        return back()->with('success','Shop deleted');
    }

    private function authorizeAction(Shop $shop){
        if (!auth()->user()->hasRole('owner') || $shop->owner_id !== auth()->id()) abort(403);
    }
}
