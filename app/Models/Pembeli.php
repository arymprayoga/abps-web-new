<?php

namespace App\Models;

use Google\Cloud\Firestore\FirestoreClient;

class Pembeli{

    public function initialize(){
        $firestore = app('firebase.firestore')->database();
        return $firestore;
    }

    public static function readPembeli(){
        $pembeli = new Pembeli();
        $firestore = $pembeli->initialize();
        $collection = $firestore->collection('pembeli');
        $firstQuery = $collection->orderBy('nama');
        $pembeli = $firstQuery->documents();
        return $pembeli;
    }

    public static function addPembeli(array $data){
        $pembeli = new Pembeli();
        $firestore = $pembeli->initialize();
        $docRef= $firestore->collection('pembeli')->newDocument();
        $docRef->set($data);
        return $firestore;
    }

    public static function editPembeli(array $data){
        $pembeli = new Pembeli();
        $firestore = $pembeli->initialize();
        $pembeli = $firestore->collection('pembeli')->document($data['id']);
        $pembeli->update([
            ['path' => 'nama', 'value' => $data['nama']],
            ['path' => 'email', 'value' => $data['email']],
            ['path' => 'password', 'value' => $data['password']],
            ['path' => 'statusVerifikasi', 'value' => $data['statusVerifikasi']],
            ['path' => 'lokasi', 'value' => $firestore->geoPoint($data['latitude'], $data['longitude'])] ,
            ['path' => 'noTelp', 'value' => $data['noTelp']]
            ]);
        
        return $firestore;
    }

    public static function deletePembeli(String $id){
        $pembeli = new Pembeli();
        $firestore = $pembeli->initialize();
        $firestore->collection('pembeli')->document($id)->delete();
        return $firestore;
    }

    public static function readPembeliNonaktif(){
        $pembeli = new Pembeli();
        $firestore = $pembeli->initialize();
        $collection = $firestore->collection('pembeli');
        $firstQuery = $collection->where('statusVerifikasi', '=', 'nonaktif');
        $pembeli = $firstQuery->documents();
        return $pembeli;
    }

    public static function verifikasiPembeli(String $data){
        $pembeli = new Pembeli();
        $firestore = $pembeli->initialize();
        $pembeli = $firestore->collection('pembeli')->document($data);
        $pembeli->update([
            ['path' => 'statusVerifikasi', 'value' => 'aktif'],
            ]);
        
        return $firestore;
    }
}