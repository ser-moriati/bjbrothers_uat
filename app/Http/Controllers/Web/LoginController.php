<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Product;
use App\Cart;
use Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/account';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
        $this->middleware('guest:member')->except('logout');
    }

    public function showMemberLoginForm(Request $request)
    {
        // return session('redirect_url');
        return view('login');
    }

    public function memberLogin(Request $request)
    {
        // return $request;
        // $this->validate($request, [
        //     'email'   => 'required',
        //     'password' => 'required|min:6'
        // ]);

        if (Auth::guard('member')->attempt(['username' => $request->email, 'password' => $request->password])) {
            $redirects = session('redirect_url') != null ? session('redirect_url') : 'account';
            $request->session()->forget('redirect_url');
            $member_id = Auth::guard('member')->user()->id;

    //     if (Session::has('quotation_cart')) {
    //         $quotation_cart = Session::get('quotation_cart');
            
    //         foreach ($quotation_cart as $quotation_item) {
                
    //             $product = Product::where('id', $quotation_item['id'])->first();
                
    //             $cart = new Cart;
    //             $cart->ref_member_id = $member_id;
    //             $cart->ref_product_id = $quotation_item['id'];
                
    //             if (!empty($product->color_id)) {
    //                 $cart->ref_color_id = $product->color_id;
    //             }
                
    //             if (!empty($product->size_id)) {
    //                 $cart->ref_size_id = $product->size_id;
    //             }
                
    //             $cart->qty = (!empty($quotation_item['qty'])) ? $quotation_item['qty'] : 1;
                
    //             $cart->save();

    //         }
    //     }
    // Session::put('quotation_cart');
            return redirect($redirects)->with('message', 'Logged in!')->with('message_status', 'success');
        }
        
        return back()->withInput($request->only('email', 'remember'));
        
    }
    public function logout(){
        auth('member')->logout();
        return redirect('login');
    }
}
