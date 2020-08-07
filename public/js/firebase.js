// importScripts('https://www.gstatic.com/firebasejs/7.17.1/firebase-app.js');
// importScripts('https://www.gstatic.com/firebasejs/7.17.1/firebase-analytics.js');
// importScripts('https://www.gstatic.com/firebasejs/7.17.1/firebase-messaging.js');

const firebaseConfig = {
    apiKey: "AIzaSyDqZIzk7AFBFitYnUJYcNhlFA8Hhmubm7s",
    authDomain: "ingetnihapp-40e2e.firebaseapp.com",
    databaseURL: "https://ingetnihapp-40e2e.firebaseio.com",
    projectId: "ingetnihapp-40e2e",
    storageBucket: "ingetnihapp-40e2e.appspot.com",
    messagingSenderId: "722292301513",
    appId: "1:722292301513:web:f3ab20e0d5978b240ef718",
    measurementId: "G-Q5S4BTCL9Z"
  };
  
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  // firebase.analytics();
  
  const messaging = firebase.messaging();
  messaging
  // .usePublicVapidKey('BPtClrdn9lQn5XOAAKdIJFYT6pXGOfZWOQY6FgvtOQJICZ-8KC5ncRFiL5b51TUj7xO70gaOZ0bSw8O7x2uzCic')
  .requestPermission()
  .then(function() {
      console.log("Notif Permission Granted!");
      return messaging.getToken()
      
  }).then(function(token){
      $('#device_token').val(token)
      console.log(token)
      
  }).catch(function(err){
      console.log("Unable grant permission to notify".err);
  });

  messaging.onMessage((payload) => {
    console.log(payload);
})
















// ================================START GOOGLE================================
  // messaging.getToken().then((currentToken) => {
    //     if (currentToken) {
      //       console.log(currentToken); 
      //       // sendTokenToServer(currentToken);
      //       // updateUIForPushEnabled(currentToken);
//     } else {
//       // Show permission request.
//       console.log('No Instance ID token available. Request permission to generate one.');
//       // Show permission UI.
//       updateUIForPushPermissionRequired();
//       setTokenSentToServer(false);
//     }
//   }).catch((err) => {
//     console.log('An error occurred while retrieving token. ', err);
//     showToken('Error retrieving Instance ID token. ', err);
//     setTokenSentToServer(false);
//   });
// ================================END GOOGLE================================  




