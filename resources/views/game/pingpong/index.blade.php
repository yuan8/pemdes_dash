<!DOCTYPE html>
<html>
  <head>
    <!-- meta tags are not necessary here, but having them always is a good practice -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- title -->
    <title>Ping Pong Game</title>
    <!-- some css styles -->
    <style>
      * {
        padding: 0;
        margin: 0;
      }

      body {
        width: 100vw;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
      }
    </style>
  </head>
  <body>

    <!-- our "canvas" where we draw things-->
    <canvas id="canvas" width="600" height="400">
      
    </canvas>

    <!-- link to script.js -->
    <script type="text/javascript" src="{{url('game_src/js/script.js')}}"></script>
    <script type="text/javascript">
      const bc = new BroadcastChannel('build_berita_acara');

      bc.onmessage=function(ev){
        var txt;
        var r = confirm(ev.data.text+',TUTUP GAME INI ?');
        if (r == true) {
          window.close();
          txt = "You pressed OK!";
        } else {
          
        }

        // alert(ev.data.text);
        console.log('message',ev.data);
      } 
    </script>
  </body>
</html>