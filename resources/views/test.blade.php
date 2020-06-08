<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>GPS 測試</title>
    <script type="text/javascript" src="http://code.google.com/apis/gears/gears_init.js"></script>
    <script>
        /*if (navigator.geolocation) {
            alert("GPS已被定位....千萬不可以動手!!!");
            // 支援GPS地理定位
            navigator.geolocation.getCurrentPosition(geoYes, geoNo, {maximumAge:60000, timeout:20000, enableHighAccuracy:true});
        } else {
            alert("目前GPS無法定位....趕快補刀吧!!!");
        }*/
        // 瀏覽器支援 HTML5 定位方法
        if (navigator.geolocation) {
            // HTML5 定位抓取
            navigator.geolocation.getCurrentPosition(function(position) {
                    mapServiceProvider(position.coords.latitude, position.coords.longitude, position.coords.accuracy);
                },
                function(error) {
                    switch (error.code) {
                        case error.TIMEOUT:
                            alert('連線逾時');
                            break;

                        case error.POSITION_UNAVAILABLE:
                            alert('無法取得定位');
                            break;

                        case error.PERMISSION_DENIED: // 拒絕
                            alert('想要參加本活動，\n記得允許手機的GPS定位功能喔!');
                            break;

                        case error.UNKNOWN_ERROR:
                            alert('不明的錯誤，請稍候再試');
                            break;
                    }
                });
        } else { // 不支援 HTML5 定位
            // 若支援 Google Gears
            if (window.google && google.gears) {
                try {
                    // 嘗試以 Gears 取得定位
                    var geo = google.gears.factory.create('beta.geolocation');
                    geo.getCurrentPosition(successCallback, errorCallback, {
                        enableHighAccuracy: true,
                        gearsRequestAddress: true
                    });
                } catch (e) {
                    alert('定位失敗請稍候再試');
                }
            } else {
                alert('想要參加本活動，\n記得允許手機的GPS定位功能喔!');
            }
        }

        // 取得 Gears 定位發生錯誤
        function errorCallback(err) {
            var msg = 'Error retrieving your location: ' + err.message;
            alert(msg);
        }

        // 成功取得 Gears 定位
        function successCallback(p) {
            mapServiceProvider(p.latitude, p.longitude);
        }

        // 顯示經緯度
        function mapServiceProvider(latitude, longitude, accuracy) {
            alert('經緯度：' + latitude + ', ' + longitude);
            str = "緯度" + latitude;
            str += "<br />經度" + longitude;
            str += "<br />精確度" + accuracy;
            // str += 等於=> str = str+....
            document.getElementById("posStr").innerHTML = str;
        }

        function geoYes(evt) {
            //alert(evt);
            var location_timeout = setTimeout("geolocFail()", 10000);
            clearTimeout(location_timeout);
            str = "緯度" + evt.coords.latitude;
            str += "<br />經度" + evt.coords.longitude;
            str += "<br />精確度" + evt.coords.accuracy;
            // str += 等於=> str = str+....
            document.getElementById("posStr").innerHTML = str;
        }

        function geoNo(evt) {
            var location_timeout = setTimeout("geolocFail()", 10000);
            clearTimeout(location_timeout);
            alert("GPS取得失敗");
        }

        var watchID;

        function startGPS() {
            watchID = navigator.geolocation.watchPosition(geoYes, geoNo);
            document.getElementById("watchStr").innerHTML = "GPS 正在監控中...";
        }

        function stopGPS() {
            navigator.geolocation.clearWatch(watchID);
            document.getElementById("watchStr").innerHTML = "GPS 停止監控中...";
        }

        function geolocFail() {
            alert("GPS取得失敗");
        }
    </script>
</head>

<body>
    定位資訊
    <p id="posStr">111222</p>
    <p id="watchStr">監控狀態</p>
    <p>
        <input type="button" value="啟動 GPS 更新" onclick="startGPS();">
        <input type="button" value="停止 GPS 更新" onclick="stopGPS();">
    </p>
    <p>當啟動GPS更新，不用聯網也可持續更新！！！<br>
        只要網頁開著!</p>
</body>