<?php

namespace App\Models;

use Google\Cloud\Firestore\FirestoreClient;

class BarangSistem{

    public function initialize(){
        $firestore = app('firebase.firestore')->database();
        return $firestore;
    }

    public static function readBarangSistem(){
        $barangSistem = new BarangSistem();
        $firestore = $barangSistem->initialize();
        $collection = $firestore->collection('barangSistem');
        $firstQuery = $collection->orderBy('namaBarang');
        $barangSistem = $firstQuery->documents();
        return $barangSistem;
    }

    public static function addBarangSistem(array $data){
        $barangSistem = new BarangSistem();
        $firestore = $barangSistem->initialize();

        $docRef =  $firestore->collection('barangSistem')->newDocument();
        $docRef->set($data);
        return 'Sukses';
    }

    public static function deleteBarangSistem(String $id){
        $barangSistem = new BarangSistem();
        $firestore = $barangSistem->initialize();
        $barang = $firestore->collection('barangSistem')->document($id)->snapshot();

        app('firebase.storage')->getBucket()->object($barang['fotoBarang'])->delete();

        $firestore->collection('barangSistem')->document($id)->delete();
        return 'Sukses';
    }

    public static function editBarangSistem(array $data){
        $barangSistem = new BarangSistem();
        $firestore = $barangSistem->initialize();

        $editBarang = $firestore->collection('barangSistem')->document($data['id']);
        $editBarang->update([
            ['path' => 'namaBarang', 'value' => $data['namaBarang']],
            ['path' => 'hargaBarang', 'value' => $data['hargaBarang']],
            ['path' => 'fotoBarang', 'value' => $data['fotoBarangBaru']]
            ]);

        app('firebase.storage')->getBucket()->object($data['fotoBarang'])->delete();
        
        return 'Sukses';
    }
    
}