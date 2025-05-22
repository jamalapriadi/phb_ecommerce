<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;

class CustomerAuthController extends Controller
{
    //fungsi untuk menampilkan halaman login
    public function login(){
        return view('web.customer.login',[
            'title'=>'Login'
        ]);
    }

    //fungsi untuk menampilkan halaman register
    public function register(){
        return view('web.customer.register',[
            'title'=>'Register'
        ]);
    }

    //fungsi untuk aksi login, ketika button login di klik
    public function store_login(Request $request)
    {
        //cek dulu validasinya
        $credentials = $request->only('email', 'password');

        $validasi = \Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //jika validasi gagal
        if ($validasi->fails()) {
            //jika validasi gagal
            //redirect ke halaman sebelumnya
            //dengan pesan error
            //dan list errornya apa aja

            return redirect()->back()
                ->with('errorMessage', 'Validasi error, silahkan cek kembali data anda')
                ->withErrors($validasi)
                ->withInput();
        }

        //cek dulu di table customer, email yang diisi ada atau ngga
        $customer = Customer::where('email',$credentials['email'])->first();

        //kita cek apakah customer ini ada,
        //jika ada, kita cek password customer sama atau ngga dengan password yang diinput
        if($customer && \Hash::check($credentials['password'], $customer->password)){
            //jika sama, maka set login
            \Auth::guard('customer')->login($customer);

            //jika berhasil login
            //kita akan arahkan ke halaman home

            return redirect()->route('home')
                ->with('successMessage', 'Login berhasil');
        }else{
            //jika tidak sama, 
            //maka redirect ke halaman sebelumnya dengan pesan error

            return redirect()->back()
                ->with('errorMessage', 'Email atau password salah')
                ->withInput();
        }

        //jika validasi berhasil aksinya apa
    }

    //fungsi untuk aksi register, ketika button register di klik
    public function store_register(Request $request)
    {
        //validasi input dari user
        $validasi = \Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:customers,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        //kita cek, apakah validasinya berhasil atau tidak
        //jika validasi gagal
        if($validasi->fails()){
            //jika validasi gagal
            //kita akan redirect ke halaman sebelumnya
            //dengan menampilkan error message 
            //dan list errornya apa aja?

            return redirect()->back()
                ->with('errorMessage', 'Validasi error, silahkan cek kembali data anda')
                ->withErrors($validasi)
                ->withInput();

        }else{
            //jika validasi berhasil, maka simpan data customer
            //dan redirect ke halaman login

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

    //fungsi untuk logout
    public function logout(Request $request)
    {
        \Auth::guard('customer')->logout();

        return redirect()->route('customer.login')
            ->with('successMessage', 'Anda telah berhasil logout');
    }
}
