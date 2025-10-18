<?php
namespace App\Http\Controllers;

use App\Models\Shopkeeper;
use App\Models\User;
use Illuminate\Http\Request;

class ShopkeeperController extends Controller
{
    public function index(){
        $shopkeepers = Shopkeeper::with(['user','shop'])->get();
        return view('shopkeepers.index', compact('shopkeepers'));
    }

    public function store(Request $request){
        $request->validate(['email'=>'required|email','shop_id'=>'required|exists:shops,id']);
        $user = User::where('email',$request->email)->first();
        if(!$user) return back()->with('error','User not found. Create user first.');
        $user->assignRole('shopkeeper');
        Shopkeeper::updateOrCreate(['user_id'=>$user->id], ['shop_id'=>$request->shop_id]);
        return back()->with('success','Shopkeeper assigned');
    }

    public function destroy(Shopkeeper $shopkeeper){
        $shopkeeper->delete();
        return back()->with('success','Shopkeeper removed');
    }
}
