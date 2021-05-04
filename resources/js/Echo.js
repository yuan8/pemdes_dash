import Echo from 'laravel-echo';

window.io = require('socket.io-client');





window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6005',
    auth: {
    	headers: {
    		Authorization: "Bearer " + window.METAUSER.api_token
    	}
    }
});



window.notifO=new Vue({
	el:'#notification_status',
	data:{
		permission_status:false,
	},
	methods:{
		'fire':function(data){
		 if (Notification.permission === "granted") {
		     new Notification(data.title,data.options);
		  }
		},
		'request':function(){
			if (!("Notification" in window)) {
		    	alert("This browser does not support desktop notification");
		  	}
		 	else if (Notification.permission === "granted") {
		   		this.permission_status=true;
		  	}
		 	else if (Notification.permission !== "denied") {
		   		 Notification.requestPermission().then(function (permission) {
			      if (permission === "granted") {
			        this.permission_status=true;
			      }
		    });
		  }
		}
	}
});
