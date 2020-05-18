
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