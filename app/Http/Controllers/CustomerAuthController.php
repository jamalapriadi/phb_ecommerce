<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;

class CustomerAuthController extends Controller
{
    //function untuk menampilkan halaman login
    public function login(){
        return view('web.customer.login',[
            'title'=>'Login'
        ]);
    }

    //function untuk menampilkan halaman register
    public function register(){
        return view('web.customer.register',[
            'title'=>'Register'
        ]);
    }

    //fungsi untuk aksi register
    public function store_register(Request $request)
    {
        //validasi
        $validasi = \Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:customers,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        if($validasi->fails())
        {
            //jika validasi gagal, maka kita kembalikan ke form sebelumya
            return redirect()->back()
                ->with('errorMessage', 'Validasi error, silahkan cek kembali data anda')
                ->withErrors($validasi)
                ->withInput();
        }else{
            //jika validasi berhasil, maka save data customer
            $customer = new Customer;
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->password = \Hash::make($request->password);
            $customer->save();

            //jika berhasil tersimpan, maka redirect ke halaman login
            return redirect()->route('customer.login')
                ->with('successMessage','Registrasi Berhasil');
        }
    }
    
    //fungsi untuk aksi login
    public function store_login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //validasi
        $validasi = \Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //kita cek dulu validasi berhasil atau tidak
        if($validasi->fails()){
            //jika validasi gagal
            return redirect()->back()
                ->with('errorMessage', 'Validasi error, silahkan cek kembali data anda')
                ->withErrors($validasi)
                ->withInput();
        }

        //jika validasi berhasil
        //kita cek dulu, email yang dikirim ada di data customer atau ngga
        $customer = Customer::where('email', $credentials['email'])->first();

        //jika ada, cek password customer di database dengan input password apakah sama atau tidak
        if($customer && \Hash::check($credentials['password'], $customer->password)){
            //jika sama, maka set login
            \Auth::guard('customer')->login($customer);

            //jika sudah login, maka redirect ke halaman home
            return redirect()->route('home')
                ->with('successMessage', 'Login berhasil');

        }else{
            //jika customer tidak ditemukan, atau passwordnya tidak sama
            //maka redirect back, dengan pesan error
            return redirect()->back()
                ->with('errorMessage', 'Email atau password salah')
                ->withInput();
        }
    }

    //fungsi untuk logout
    public function logout(Request $request){
        \Auth::guard('customer')->logout();

        return redirect()->route('customer.login')
            ->with('successMessage', 'Anda telah berhasil logout');
    }
}
