    countdown = false;
    fillStarted = false;
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

    function showToast(duration) {
        // Get the snackbar DIV
        var x = document.getElementById("snackbar");
        // After x seconds, remove the show class from DIV
        setTimeout(function(){x.className = ""}, duration);
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
                document.getElementById("outputField").innerHTML = this.responseText.split('\n')[0];
                if(!this.responseText.includes("finished")){
                    var percentage = this.responseText.split('\n')[2];
                    document.getElementById("fillProgress").innerText = percentage + '%';
                    document.getElementById("fillProgress").setAttribute("aria-valuenow", percentage);
                    document.getElementById("fillProgress").style.width = percentage + '%';
                    sendAjaxStep(step+1);
                } else {
                    document.getElementById("outputField").innerHTML = "Finished!";
                    document.getElementById("fillProgress").style.width = '100%';
                    document.getElementById("fillProgress").innerText = '100%';
                    document.getElementById("fillProgress").setAttribute("aria-valuenow", 100);
                }
            }
        };
        xmlhttp.open("POST", "ajax.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send('request=fillCatalogus&step='+ step);
    }

    function startDatabaseFill(){
        if(!fillStarted) { // if the fill hasn't started yet
            if (confirm("Are you sure you want to fill the database?(This could take atleast 15 minutes)")) {
                fillStarted = true;
                document.getElementById("loader").style.display = 'block';
                document.getElementById("databaseFillButton").innerText = "Abort!";
                sendAjaxStep(0);
            }
        } else { // abort the filling
            xmlhttp.abort();
            document.getElementById("loader").style.display = 'none';
            document.getElementById("databaseFillButton").innerText = "Start Filling!";
            fillStarted = false;
        }
    }

    $(document).ready(function(){
        setInterval(
        function notify(){
            $.post("ajax.php",
                {
                    request: "getNotifications"
                },
                function(data,status){
                    if (!$.trim(data)){
                        $("#notificationsDropdown").text('0');
                        updateIcon(false); // you don't have notifications
                    } else {
                        $("#notificationsDropdown").text($.trim(data));
                        updateIcon(true); // you have notifications
                        sendPushNotification("Je hebt" + data + " notificaties");
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

    function sendPushNotification(message){
        if (!("Notification" in window)) {
            alert("This browser does not support desktop notification");
        } else if (Notification.permission === "granted") {
            var notification = new Notification(message, {
                icon: 'https://iproject38.icasites.nl/images/icon.svg'
            });
        } else if (Notification.permission !== "denied") {
            Notification.requestPermission().then(function (permission) {
                if (permission === "granted") {
                    var notification = new Notification(message, {
                        icon: 'https://iproject38.icasites.nl/images/icon.svg'
                    });
                }
            });
        }
    }
    function updateMessages(){
        //alert("updating chat");
        $.post("ajax.php",
            {
                request: "getMessages",
                responder: responder
            },
            function(data,status){
                $("#chatWindow").html(data);
            });
        return updateMessages;
    }
    function startChat(chatter){
        responder = chatter;
        $(document).ready(function(){
            setInterval(updateMessages(), 2000);
        });
    }

    function sendChatMessage(receiver){
        var message = $("#chatMessage").val();
        $.post("ajax.php",
            {
                request: "sendMessages",
                message: message,
                receiver: receiver
            },
            function(data, status){
                updateMessages();
            }
            );
    }