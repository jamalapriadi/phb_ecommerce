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

    //fungsi untuk melakukan aksi login, ketika button login di klik
    public function store_login(Request $request){
        /** 
         * 1. validasi input, sudah benar atau belum (email dan password harus diisi)
         * 2. cek validasi, kalo gagal, kita akan redirect ke halaman sebelumnya
         * dengan pesan error "silahkan lengkapi data"
         * 3. cek dulu, apakah email yang dimasukkan sudah ada di 
         * data customer atau belum
         * 4. cek password yang dimasukkan user dengan password email yang ada 
         * di database
         * 5. jika sudah benar, maka set status nya login
         * 6. jika salah, redirect ke halaman login dengan pesan error
         * "salah"
         * */   

        $credentials = $request->only('email', 'password');

        /** 1, cek validasi */
        $validasi = \Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        /** 2. jika validasi gagal */
        if ($validasi->fails()) {
            return redirect()->back()
                ->with('errorMessage', 'Validasi error, silahkan cek kembali data anda')
                ->withErrors($validasi)
                ->withInput();
        }

        /** 3. cek data email di tabel customer ada atau tidak */
        $customer = Customer::where('email', $credentials['email'])->first();

        /** 4. jika data customer ditemukan, maka cek password yang 
         * ada di database, apakah sama dengan password yang di input
         */
        if ($customer && \Hash::check($credentials['password'], $customer->password)) {
            /** jika benar, maka set login */
            \Auth::guard('customer')->login($customer);

            return redirect()->route('home')
                ->with('successMessage', 'Login berhasil');
        }else{
            /** jika salah */
            return redirect()->back()
                ->with('errorMessage', 'Email atau password salah')
                ->withInput();
        }
    }

    //fungsi untuk melakukan aksi register, ketika button register di klik
    public function store_register(Request $request){
        /**
         * 1. cek validasi, input dari user sudah benar atau belum
         * 2. jika validasi salah, kita akan kembalikan ke halaman sebelumya
         * dengan pesan error "validasi error"
         * 3. jika validasi benar, maka simpan data yang di input oleh user
         * ke dalam tabel customer
         */

        /** validasi */
        $validasi = \Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:customers,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        /** jika validasi error */
        if($validasi->fails()){
            return redirect()->back()
                ->with('errorMessage', 'Validasi error, silahkan cek kembali data anda')
                ->withErrors($validasi)
                ->withInput();
        }else{
            /** jika validasi benar, simpan data customer */

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

    //fungsi untuk aksi logout
    public function logout(Request $request){
        \Auth::guard('customer')->logout();

        return redirect()->route('customer.login')
            ->with('successMessage', 'Anda telah berhasil logout');
    }
}
