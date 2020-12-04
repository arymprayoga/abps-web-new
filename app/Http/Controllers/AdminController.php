<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Firestore\FirestoreClient;
use App\Models\Admin;
use App\Models\Pedagang;
use App\Models\Pembeli;
use App\Models\BarangSistem;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    protected $db;
    public function __construct()
    {
        $this->db = app('firebase.firestore')->database();
    }

    public function index(Request $request)
    {
        // session(['authenticated' => false]);
        // $value = session()->get('authenticated');
        // return $value;
        // $docRef =  $this->db->collection('admin');
        // $query = $docRef;

        // // if(isset($request->search))
        // //     $query = $docRef->where('name', '=', $request->search);

        // $documents = $query->documents();
        // foreach ($documents as $document) {
        //     if ($document->exists()) {
        //         printf('Document data for document %s:' . PHP_EOL, $document->id());
        //         printf($document->documents()->nama);
        //         printf(PHP_EOL);
        //     } else {
        //         printf('Document %s does not exist!' . PHP_EOL, $snapshot->id());
        //     }
        // }


        // $firebase_storage_path = 'FotoBarang/';
        // $file = 'maid.png';
        // $localfolder = public_path('foto') .'/';
        // $fileName = 'test_maid.png';
        // $uploadedfile = fopen($localfolder.$file, 'r');
        // $test = app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $fileName]);
        // // var_dump($test);

        // $docRef =  $this->db->collection('barangSistem')->newDocument();
        // $docRef->set([
        //     'namaBarang' => 'John',
        //     'hargaBarang'  => 'Doe',
        //     'fotoBarang'       => $firebase_storage_path.$fileName,
        //   ]);

        // $test = $this->db->collection('barangSistem')->where('namaBarang', '==', 'John')->documents();
        // $fotoGan = '';
        // foreach($test as $h){
        //     // printf($h->id());
        //     // printf($h->data()['namaBarang']);
        //     // printf($h->data()['hargaBarang']);
        //     // printf($h->data()['fotoBarang']);
        //     $fotoGan = $h->data()['fotoBarang'];
        // }
        // echo $fotoGan;

        // $expiresAt = new \DateTime('tomorrow');
        // $imageReference = app('firebase.storage')->getBucket()->object($fotoGan);
        // if($imageReference->exists())
        // $image = $imageReference->signedUrl($expiresAt);
        // echo $image;
    }

    public function initialize()
    {
        $firestore = app('firebase.firestore')->database();
        return $firestore;
    }

    public function login(Request $request)
    {
        $admin = new AdminController();
        $firestore = $admin->initialize();
        $collection = $firestore->collection('admin');
        $firstQuery = $collection->where('email', '=', $request['email']);
        $documents = $firstQuery->documents();
        $uname = '';
        $check = 0;
        foreach ($documents as $document) {
            if ($document->exists()) {
                if (Hash::check($request['password'], $document['password'])) {
                    $check = 1;
                    $uname = $document['nama'];
                }
            }
        }
        if ($check == 0) {
            return 'Username atau Password Salah';
        } else {
            session(['authenticated' => true]);
            session(['username' => $uname]);
            return redirect('/dashboard-admin');
        }
        // $value = session()->get('authenticated');
        // return $value;

    }

    public function logout()
    {
        session()->forget('authenticated');
        return redirect()->guest('/');
    }

    public function showDashboardAdminPage()
    {
        // $admin = new Admin();
        // $test = $admin->readData();
        // return $test;
        // return $uname;
        return view('dashboard-admin');
    }

    public function showDaftarAdminPage()
    {
        $admin = Admin::readAdmin();
        // return $admin;
        return view('daftar-admin', compact('admin'));
    }

    public function tambahAdmin(Request $request)
    {
        $admin = new AdminController();
        $hashedPassword = Hash::make($request['password']);
        $firestore = $admin->initialize();
        $collection = $firestore->collection('admin');
        $firstQuery = $collection->where('email', '=', $request['email']);
        $documents = $firstQuery->documents();
        $check = 0;
        foreach ($documents as $document) {
            if ($document->exists()) {
                $check = 1;
            }
        }
        if ($check == 0) {
            $data = [
                'nama' => $request['nama'],
                'email' => $request['email'],
                'password' => $hashedPassword
            ];

            $firestore = Admin::addAdmin($data);
            return back();
        } else {
            echo "User already exists";
        }
    }

    public function editAdmin(Request $request)
    {
        $data = [
            "id" => $request['id'],
            "nama" => $request['nama'],
            "email" => $request['email']
        ];

        $firestore = Admin::editAdmin($data);

        return back();
    }

    public function deleteAdmin(Request $request)
    {
        $id = $request['id'];
        $firestore = Admin::deleteAdmin($id);
        return back();
    }

    public function showDaftarPedagangPage()
    {
        $pedagang = Pedagang::readPedagang();

        return view('daftar-pedagang', compact('pedagang'));
    }

    public function tambahPedagang(Request $request)
    {
        $pedagang = new AdminController();
        $firestore = $pedagang->initialize();
        $collection = $firestore->collection('pedagang');
        $firstQuery = $collection->where('email', '=', $request['email']);
        $documents = $firstQuery->documents();
        $check = 0;
        foreach ($documents as $document) {
            if ($document->exists()) {
                $check = 1;
            }
        }
        if ($check == 0) {
            $data = [
                'nama' => $request['nama'],
                'email' => $request['email'],
                'password' => $request['password'],
                'rating' => $request['rating'],
                'statusVerifikasi' => $request['statusVerifikasi'],
                'statusDagang' => $request['statusDagang'],
                'lokasi' => $firestore->geoPoint($request['latitude'], $request['longitude']),
                'noKTP' => $request['noKTP'],
                'noTelp' => $request['noTelp']
            ];

            $firestore = Pedagang::addPedagang($data);
            return back();
        } else {
            echo "SAMAWOY";
        }
    }

    public function editPedagang(Request $request)
    {
        $data = [
            'id' => $request['id'],
            'nama' => $request['nama'],
            'email' => $request['email'],
            'password' => $request['password'],
            'rating' => $request['rating'],
            'statusVerifikasi' => $request['statusVerifikasi'],
            'statusDagang' => $request['statusDagang'],
            'latitude' => $request['latitude'],
            'longitude' => $request['longitude'],
            'noKTP' => $request['noKTP'],
            'noTelp' => $request['noTelp']
        ];
        $firestore = Pedagang::editPedagang($data);
        return back();
    }

    public function deletePedagang(Request $request)
    {
        $id = $request['id'];
        $firestore = Pedagang::deletePedagang($id);
        return back();
    }

    public function showDaftarPembeliPage()
    {
        $pembeli = Pembeli::readPembeli();
        return view('daftar-pembeli', compact('pembeli'));
    }

    public function tambahPembeli(Request $request)
    {
        $pembeli = new AdminController();
        $firestore = $pembeli->initialize();
        $collection = $firestore->collection('pembeli');
        $firstQuery = $collection->where('email', '=', $request['email']);
        $documents = $firstQuery->documents();
        $check = 0;
        foreach ($documents as $document) {
            if ($document->exists()) {
                $check = 1;
            }
        }
        if ($check == 0) {
            $data = [
                'nama' => $request['nama'],
                'email' => $request['email'],
                'password' => $request['password'],
                'statusVerifikasi' => $request['statusVerifikasi'],
                'lokasi' => $firestore->geoPoint($request['latitude'], $request['longitude']),
                'noTelp' => $request['noTelp']
            ];

            $firestore = Pembeli::addPembeli($data);
            return back();
        } else {
            echo "SAMAWOY";
        }
    }

    public function editPembeli(Request $request)
    {
        $data = [
            'id' => $request['id'],
            'nama' => $request['nama'],
            'email' => $request['email'],
            'password' => $request['password'],
            'statusVerifikasi' => $request['statusVerifikasi'],
            'latitude' => $request['latitude'],
            'longitude' => $request['longitude'],
            'noTelp' => $request['noTelp']
        ];
        $firestore = Pembeli::editPembeli($data);
        return back();
    }

    public function deletePembeli(Request $request)
    {
        $id = $request['id'];
        $firestore = Pembeli::deletePembeli($id);
        return back();
    }

    public function showDaftarBarangSistemPage()
    {
        $barangSistem = BarangSistem::readBarangSistem();
        return view('daftar-barang-sistem', compact('barangSistem'));
    }

    public function tambahBarangSistem(Request $request)
    {
        $barangSistem = new AdminController();
        $firestore = $barangSistem->initialize();
        $collection = $firestore->collection('barangSistem');
        $firstQuery = $collection->where('namaBarang', '=', $request['namaBarang']);
        $documents = $firstQuery->documents();
        $check = 0;
        foreach ($documents as $document) {
            if ($document->exists()) {
                $check = 1;
            }
        }
        if ($check == 0) {
            $image = $request->file('fotoBarang');
            $firebase_storage_path = 'FotoBarang/';
            $file = $request->fotoBarang->hashName();
            $localfolder = public_path('firebase-temp-uploads') . '/';
            if ($image->move($localfolder, $file)) {

                $uploadedfile = fopen($localfolder . $file, 'r');

                app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $file]);

                //will remove from local laravel folder
                unlink($localfolder . $file);

                echo 'success';
            } else {
                echo 'error';
            }

            $data = [
                'namaBarang' => $request['namaBarang'],
                'hargaBarang' => $request['hargaBarang'],
                'fotoBarang' => $firebase_storage_path . $file,
            ];

            $firestore = BarangSistem::addBarangSistem($data);
            return back();
        } else {
            echo "Item already exists";
        }
    }

    public function deleteBarangSistem(Request $request)
    {
        $id = $request['id'];
        $firestore = BarangSistem::deleteBarangSistem($id);
        return back();
    }

    public function editBarangSistem(Request $request)
    {
        $image = $request->file('fotoBarang');
        $firebase_storage_path = 'FotoBarang/';
        $file = $request->fotoBarang->hashName();
        $localfolder = public_path('firebase-temp-uploads') . '/';
        if ($image->move($localfolder, $file)) {

            $uploadedfile = fopen($localfolder . $file, 'r');

            app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $file]);

            //will remove from local laravel folder
            unlink($localfolder . $file);

            echo 'success';
        } else {
            echo 'error';
        }

        $data = [
            'id' => $request['id'],
            'namaBarang' => $request['namaBarang'],
            'hargaBarang' => $request['hargaBarang'],
            'fotoBarang' => $request['fotoBarangLama'],
            'fotoBarangBaru' => $firebase_storage_path . $file,
        ];
        $firestore = BarangSistem::editBarangSistem($data);
        return back();
    }

    public function showVerifikasiPembeliPage()
    {
        $pembeli = Pembeli::readPembeliNonaktif();
        return view('verifikasi-pembeli', compact('pembeli'));
    }

    public function verifikasiPembeli(Request $request)
    {
        $firestore = Pembeli::verifikasiPembeli($request['id']);
        return back();
    }
}
