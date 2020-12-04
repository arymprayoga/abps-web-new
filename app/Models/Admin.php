<?php

namespace App\Models;

use Google\Cloud\Firestore\FirestoreClient;

class Admin {
    
    public function initialize(){
        $firestore = app('firebase.firestore')->database();
        return $firestore;
    }

    public static function readAdmin(){
        $admin = new Admin();
        $admin = $admin->initialize();
        $admin = $admin->collection('admin')->orderBy('nama')->documents();
        return $admin;
    }

    public static function addAdmin(array $data){
        $admin = new Admin();
        $firestore = $admin->initialize();
        $docRef = $firestore->collection('admin')->newDocument();
        $docRef->set($data);
        return $docRef;
    }

    public static function editAdmin(array $data){
        $admin = new Admin();
        $firestore = $admin->initialize();
        $admin = $firestore->collection('admin')->document($data['id']);
        $admin->update([
            ['path' => 'nama', 'value' => $data['nama']],
            ['path' => 'email', 'value' => $data['email']]
            ]);
        
        return $firestore;
    }

    public static function deleteAdmin(String $id){
        $admin = new Admin();
        $firestore = $admin->initialize();
        $firestore->collection('admin')->document($id)->delete();
        // $admin = $data;
        return $firestore;
    }
}