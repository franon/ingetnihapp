// Import and configure the Firebase SDK
// These scripts are made available when the app is served or deployed on Firebase Hosting
// If you do not serve/host your project using Firebase Hosting see https://firebase.google.com/docs/web/setup
importScripts('https://www.gstatic.com/firebasejs/7.17.1/firebase-app.js');
 importScripts('https://www.gstatic.com/firebasejs/7.17.1/firebase-messaging.js');

// const messaging = firebase.messaging();

 // https://firebase.google.com/docs/web/setup#config-object
 firebase.initializeApp({
    apiKey: "AIzaSyDqZIzk7AFBFitYnUJYcNhlFA8Hhmubm7s",
    authDomain: "ingetnihapp-40e2e.firebaseapp.com",
    databaseURL: "https://ingetnihapp-40e2e.firebaseio.com",
    projectId: "ingetnihapp-40e2e",
    storageBucket: "ingetnihapp-40e2e.appspot.com",
    messagingSenderId: "722292301513",
    appId: "1:722292301513:web:f3ab20e0d5978b240ef718",
    measurementId: "G-Q5S4BTCL9Z"
 });
 // Retrieve an instance of Firebase Messaging so that it can handle background
 // messages.
 const messaging = firebase.messaging();
 // [END initialize_firebase_in_sw]
