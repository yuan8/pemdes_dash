

console.log('firebase init');
// importScripts('https://www.gstatic.com/firebasejs/8.4.2/firebase-app.js');
// importScripts('https://www.gstatic.com/firebasejs/8.4.2/firebase-messaging.js');

 var firebaseConfig = {
    apiKey: "AIzaSyAGzbEw8z8y2xNVeatcG9wc0moVJVvn0tc",
    authDomain: "pemdesdash.firebaseapp.com",
    projectId: "pemdesdash",
    storageBucket: "pemdesdash.appspot.com",
    messagingSenderId: "954250521767",
    appId: "1:954250521767:web:dfc0fd5cef41fdc6a4bf82",
    measurementId: "G-N9VSVP79GM"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();

const messaging = firebase.messaging();

navigator.serviceWorker.register(sw_root)
.then((registration) => {
  messaging.useServiceWorker(registration);

    messaging.getToken({ vapidKey: 'BOsZ0SjpIJobzkjj8gt9fPEmgDgAbMU6o_z0N-q2K5_CYgLkNloRmPGbwV62G-QdHxo6JIi5O-LIv9QKuDrtmC8' }).then((currentToken) => {
      if (currentToken) {
        console.log('token firebase is',currentToken);
        // Send the token to your server and update the UI if necessary
        // ...
      } else {
        // Show permission request UI
        console.log('No registration token available. Request permission to generate one.');
        // ...
      }
    }).catch((err) => {
      console.log('Err Get Token. ', err);
      // ...
    });


});

function subscribeTokenToTopic(token, topic) {
  fetch('https://iid.googleapis.com/iid/v1/'+token+'/rel/topics/'+topic, {
    method: 'POST',
    headers: new Headers({
      'Authorization': 'key='+fcm_server_key
    })
  }).then(response => {
    if (response.status < 200 || response.status >= 400) {
      throw 'Error subscribing to topic: '+response.status + ' - ' + response.text();
    }
    console.log('Subscribed to "'+topic+'"');
  }).catch(error => {
    console.error(error);
  })
}





messaging.onMessage((payload) => {
  console.log('Message received. ', payload);
  // ...
});