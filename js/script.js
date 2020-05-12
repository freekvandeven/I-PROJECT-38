
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

                // data van ingelogde gebruiker
                var infoSessionAccount = document.getElementById("info-session-account");
                var accSession = infoSessionAccount.textContent;
                document.write(accSession);

                // data van gebruiker met het hoogste bod
                var infoHighestBidAccount = document.getElementById("info-highestbid-account");
                var accHighestBid = infoHighestBidAccount.textContent;
                document.write(accHighestBid);

                // data van gebruiker met het hoogste bod
                var infoSellerAccount = document.getElementById("info-seller-account");
                var accSeller = infoSellerAccount.textContent;
                document.write(accSeller);

                // het voorwerp
                var infoItemName = document.getElementById("voorwerp");
                var itemName = infoItemName.textContent;
                document.write(itemName);

                if(accSession === accHighestBid){
                    document.write("Notificatie sturen naar koper");
                    pushNotificationToBuyer(itemName);
                } else if(accSession === accSeller){
                    document.write("Notificatie sturen naar verkoper");
                    pushNotificationToSeller(itemName);
                }
            }
        }, 1000);
    }