<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index(): View
    {
        $cart = session()->get('cart', []);
        $ebooks = [];
        $total = 0;

        foreach ($cart as $ebookId) {
            $ebook = Ebook::with('category')->find($ebookId);
            if ($ebook) {
                $ebooks[] = $ebook;
                $total += $ebook->price;
            }
        }

        return view('shop.cart', compact('ebooks', 'total'));
    }

    /**
     * Add an ebook to the cart.
     */
    public function add(Request $request, Ebook $ebook): RedirectResponse
    {
        $cart = session()->get('cart', []);

        // Only add if not already in cart
        if (! in_array($ebook->id, $cart)) {
            $cart[] = $ebook->id;
            session()->put('cart', $cart);

            return redirect()->back()
                ->with('success', __(':name added to cart.', ['name' => $ebook->name]));
        }

        return redirect()->back()
            ->with('info', __(':name is already in your cart.', ['name' => $ebook->name]));
    }

    /**
     * Remove an ebook from the cart.
     */
    public function remove(Ebook $ebook): RedirectResponse
    {
        $cart = session()->get('cart', []);
        $updatedCart = [];

        foreach ($cart as $ebookId) {
            if ($ebookId !== $ebook->id) { // If not the ebook to remove, reinsert into cart
                $updatedCart[] = $ebookId;
            }
        }

        session()->put('cart', $updatedCart);

        return redirect()->route('cart.index')
            ->with('success', __(':name removed from cart.', ['name' => $ebook->name]));
    }

    /**
     * Clear the entire cart.
     */
    public function clear(): RedirectResponse
    {
        session()->forget('cart');

        return redirect()->route('cart.index')
            ->with('success', __('Cart cleared.'));
    }
}
