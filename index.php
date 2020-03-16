
<html>
<head>
  <meta charset="utf-8">
  <title>WG ABSENSI</title>
  <script src="jsQR.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Ropa+Sans" rel="stylesheet">
  <link rel="shortcut icon" href="wgg.png">
  <style>
    body {
      font-family: 'Ropa Sans', sans-serif;
      color: #333;
      max-width: 640px;
      background: #f4f6f9;
      margin: 0 auto;
      position: relative;
    }

    #githubLink {
      position: absolute;
      right: 0;
      top: 12px;
      color: #2D99FF;
    }

    h1 {
      margin: 10px 0;
      font-size: 40px;
    }

    #loadingMessage {
      text-align: center;
      padding: 40px;
      background-color: #eee;
    }

    #canvas {
      width: 100%;
    }

    #output {
      margin-top: 20px;
      background: #eee;
      padding: 10px;
      padding-bottom: 0;
    }

    #output div {
      padding-bottom: 10px;
      word-wrap: break-word;
    }

    #noQRFound {
      text-align: center;
    }
    #footer{
      text-align: center;
      padding: 20px;
    }
  </style>
</head>
<body>
  <div style="text-align: center;">
    <img src="wgg.png" alt="WG" style="width: 100;">
    <h1>WG ABSENSI</h1>
  </div>
  <!-- <a id="githubLink" href="https://github.com/cozmo/jsQR">View documentation on Github</a> -->
  <!-- <p>Pure JavaScript QR code decoding library.</p> -->
  <div id="loadingMessage">🎥 Tidak ada acces Camera</div>
  <div>
    <canvas id="canvas" hidden></canvas>
  </div>
  <div id="footer">
    Copyright © WG ABSENSI 2020
  </div>
  <div id="direct">

  </div>
  <!-- <div id="output" hidden> -->
    <!-- <div id="outputMessage"></div> -->
    <!-- <div hidden><b></b> <span id="outputData"></span></div> -->
  <!-- </div> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
  <script>
    var video = document.createElement("video");
    var canvasElement = document.getElementById("canvas");
    var canvas = canvasElement.getContext("2d");
    var loadingMessage = document.getElementById("loadingMessage");
    // var outputContainer = document.getElementById("output");
    // var outputMessage = document.getElementById("outputMessage");
    // var outputData = document.getElementById("outputData");

    var pathArray = window.location.pathname.split('/');

    console.log('pathArray[1] :', pathArray[1]);




    function drawLine(begin, end, color) {
      canvas.beginPath();
      canvas.moveTo(begin.x, begin.y);
      canvas.lineTo(end.x, end.y);
      canvas.lineWidth = 4;
      canvas.strokeStyle = color;
      canvas.stroke();
    }

    // Use facingMode: environment to attemt to get the front camera on phones
    navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } }).then(function(stream) {
      video.srcObject = stream;
      video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
      video.play();
      requestAnimationFrame(tick);
    });

    function tick() {
      loadingMessage.innerText = "⌛ Menunggu...."
      if (video.readyState === video.HAVE_ENOUGH_DATA) {
        loadingMessage.hidden = true;
        canvasElement.hidden = false;
        // outputContainer.hidden = false;

        canvasElement.height = video.videoHeight;
        canvasElement.width = video.videoWidth;
        canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
        var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
        var code = jsQR(imageData.data, imageData.width, imageData.height, {
          inversionAttempts: "dontInvert",
        });
        if (code) {
          drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58");
          drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58");
          drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58");
          drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58");
          // outputMessage.hidden = true;
          // outputData.parentElement.hidden = false;
          // outputData.innerText = code.data;
          if (code.data == "WG") {
            var html ="";
            html += '<a id="to" href="http://www.wikagedung.co.id"><span></span></a>&nbsp;';
            $('#direct').append(html);
            $('#to span').trigger('click');
          }else{
            console.log("Tidak Tampil");
          }
        } else {
          // outputMessage.hidden = false;
          // outputData.parentElement.hidden = true;
        }
      }
      requestAnimationFrame(tick);
    }
  </script>
</body>
</html>
