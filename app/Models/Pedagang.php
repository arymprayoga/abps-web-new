<?php

namespace App\Models;

use Google\Cloud\Firestore\FirestoreClient;

class Pedagang{

    public function initialize(){
        $firestore = app('firebase.firestore')->database();
        return $firestore;
    }

    public static function readPedagang(){
        $pedagang = new Pedagang();
        $firestore = $pedagang->initialize();
        $collection = $firestore->collection('pedagang');
        $firstQuery = $collection->orderBy('nama');
        $pedagang = $firstQuery->documents();
        return $pedagang;
    }

    public static function addPedagang(array $data){
        $pedagang = new Pedagang();
        $firestore = $pedagang->initialize();
        $docRef = $firestore->collection('pedagang')->newDocument();
        $docRef->set($data);
        return $firestore;
    }

    public static function editPedagang(array $data){
        $pedagang = new Pedagang();
        $firestore = $pedagang->initialize();
        $pedagang = $firestore->collection('pedagang')->document($data['id']);
        $pedagang->update([
            ['path' => 'nama', 'value' => $data['nama']],
            ['path' => 'email', 'value' => $data['email']],
            ['path' => 'password', 'value' => $data['password']],
            ['path' => 'rating', 'value' => $data['rating']],
            ['path' => 'statusVerifikasi', 'value' => $data['statusVerifikasi']],
            ['path' => 'statusDagang', 'value' => $data['statusDagang']],
            ['path' => 'lokasi', 'value' => $firestore->geoPoint($data['latitude'], $data['longitude'])] ,
            ['path' => 'noKTP', 'value' => $data['noKTP']],
            ['path' => 'noTelp', 'value' => $data['noTelp']]
            ]);
        
        return $firestore;
    }

    public static function deletePedagang(String $id){
        $pedagang = new Pedagang();
        $firestore = $pedagang->initialize();
        $firestore->collection('pedagang')->document($id)->delete();
        return $firestore;
    }
}