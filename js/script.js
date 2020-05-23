    countdown = false;
    function setupCountDown(element, closingDate) {
        var el = document.getElementById(element);
        var countDownDate = closingDate.getTime();
        var x = setInterval(function () {

            var now = new Date().getTime();

            var distance = countDownDate - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            el.innerHTML = days + "d " + hours + "h "
                + minutes + "m " + seconds + "s ";

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                el.innerHTML = "EXPIRED";
            }
        }, 1000);
    }

    function setupCountdownTimers(){
    countdown = true;
        var x = setInterval(function () {
            var now = new Date().getTime();
            for (var i = 0; i < timers.length; i++){
                var el = document.getElementById("timer-" + i);
                var distance = timers[i] - now;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                el.innerHTML = days + "d " + hours + "h "
                    + minutes + "m " + seconds + "s ";
                if (distance < 0) {
                    el.innerHTML = "EXPIRED";
                }
            }
        }, 1000);
    }

    function initializeCountdownDates(dates){
        timers = [];
        for(var i = 0; i < dates.length;i++){
            timers[i]= new Date(dates[i]).getTime();
        }
    }

    function showCategory(str){
        if(str.length == 0) {
            document.getElementById("searchResult").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    document.getElementById("searchResult").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("POST", "ajax.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("request=getCategory&search=" + str);
        }
    }

    function sendAjaxStep(step){
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                document.getElementById("outputField").innerHTML = "step " + step + " completed!";
                if(!this.responseText.includes("finished")){
                    sendAjaxStep(step+1);
                } else {
                    document.getElementById("outputField").innerHTML = "Finished!";
                }
            }
        };
        xmlhttp.open("POST", "ajax.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send('request=fillCatalogus&step='+ step);
    }

    function startDatabaseFill(){
        if(confirm("Are you sure you want to fill the database?(This could take atleast 15 minutes)")) {
            sendAjaxStep(0);
        }
    }

    function abortDatabaseFill(){
        xmlhttp.abort();
    }
    /*
    function updateNotfications(){
        alert("test");
    }

    $("button").click(function(){
        $.post("demo_test_post.asp",
            {
                name: "Donald Duck",
                city: "Duckburg"
            },
            function(data, status){
                alert("Data: " + data + "\nStatus: " + status);
            });
    });
     */
    $(document).ready(function(){
        setInterval(
        function notify(){
            $.post("ajax.php",
                {
                    request: "getNotifications"
                },
                function(data,status){
                    if (!$.trim(data)){
                        updateIcon(false);
                        //alert("you don't have notifications");
                    } else {
                        updateIcon(true);
                        //alert("you have " + data + " notifications");
                    }
                });
            return notify;
        }(), 600000);
    });

    function updateIcon(notification){
        var icon = 'images/icon.svg';
        var iconNotifcation = 'images/notification.svg';
        if(notification){
            document.getElementById('favicon').href = iconNotifcation;
        }else{
            document.getElementById('favicon').href = icon;
        }
    }