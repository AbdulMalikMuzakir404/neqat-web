<?php

return [
    'apiKey' => env('FIREBASE_API_KEY'),
    'authDomain' => env('FIREBASE_AUTH_DOMAIN'),
    'projectId' => env('FIREBASE_PROJECT_ID'),
    'storageBucket' => env('FIREBASE_STORAGE_BUCKET'),
    'messagingSenderId' => env('FIREBASE_MESSAGING_SENDER_ID'),
    'appId' => env('PUSHER_APP_ID'),
    'measurementId' => env('FIREBASE_MEASUREMENT_ID'),
    'serverKey' => env('FIREBASE_SERVER_KEY')
];
