
@extends('layouts.app')

@section('content_header')
@stop

@section('content')
<h5>mess {{Auth::User()->id}} -> {{Auth::User()->name}}</h5>
<div id="messages"></div>
<button id="button">Notify me!</button>

@stop 

@section('js')
<script type="text/javascript">


	// var cc;
	setTimeout(function(){
		window.c=window.Echo.channel('my-channel')
       .listen('.my-chat', function (e) {
       		console.log(e);
           $('#messages').append('<p>' + e.message + '</p>');
        });
   },500);

	function notifyMe() {
	  // Let's check if the browser supports notifications
	  if (!("Notification" in window)) {
	    alert("This browser does not support desktop notification");
	  }

	  // Let's check whether notification permissions have already been granted
	  else if (Notification.permission === "granted") {
	    // If it's okay let's create a notification
	    var notification = new Notification("Hi there!");
	  }

	  // Otherwise, we need to ask the user for permission
	  else if (Notification.permission !== "denied") {
	    Notification.requestPermission().then(function (permission) {
	      // If the user accepts, let's create a notification
	      if (permission === "granted") {
	        var notification = new Notification("Hi there!");
	      }
	    });
	  }

	  // At last, if the user has denied notifications, and you
	  // want to be respectful there is no need to bother them any more.
	}



	roomId=100;

	$(function(){
		Echo.join(`chat.${roomId}`)
	    .here((users) => {
	        //
	        console.log(users);
	    })
	    .joining((user) => {

	        console.log(user.name);
	    })
	    .leaving((user) => {

	        console.log(user.name);
	    });


	  Echo.private('App.User.' + '{{Auth::User()->id}}')
	    .notification((notification) => {
	        notifyMe();
	        console.log(notification);
	    });

	});

	

	window.addEventListener('load', function () {
	  var button = document.getElementById('button');
	  console.log(button);

	  button.addEventListener('click', function () {
	    // If the user agreed to get notified
	    // Let's try to send ten notifications
	    if (window.Notification && Notification.permission === "granted") {
	      var i = 0;
	      // Using an interval cause some browsers (including Firefox) are blocking notifications if there are too much in a certain time.
	      var interval = window.setInterval(function () {
	        // Thanks to the tag, we should only see the "Hi! 9" notification
	        var n = new Notification("Hi! " + i, {tag: 'soManyNotification'});
	        if (i++ == 9) {
	          window.clearInterval(interval);
	        }
	        console.log('notif');
	      }, 200);
	    }

	    // If the user hasn't told if they want to be notified or not
	    // Note: because of Chrome, we are not sure the permission property
	    // is set, therefore it's unsafe to check for the "default" value.
	    else if (window.Notification && Notification.permission !== "denied") {
	        console.log('notif denied');

	      Notification.requestPermission(function (status) {
	        // If the user said okay
	        if (status === "granted") {
	          var i = 0;
	          // Using an interval cause some browsers (including Firefox) are blocking notifications if there are too much in a certain time.
	          var interval = window.setInterval(function () {
	            // Thanks to the tag, we should only see the "Hi! 9" notification
	            var n = new Notification("Hi! " + i, {tag: 'soManyNotification'});
	            if (i++ == 9) {
	              window.clearInterval(interval);
	            }
	          }, 200);
	        }

	        // Otherwise, we can fallback to a regular modal alert
	        else {
	          alert("Hi!");
	        }
	      });
	    }

	    // If the user refuses to get notified
	    else {
	      // We can fallback to a regular modal alert
	      alert("Hi!");
	    }
	  });
	});

</script>
@stop
