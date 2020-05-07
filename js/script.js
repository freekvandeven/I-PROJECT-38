
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

    function addFields(){
        // Number of inputs to create
        var number = document.getElementById("member").value;
        // Container <div> where dynamic content will be placed
        var container = document.getElementById("container");
        // Clear previous contents of the container
        while (container.hasChildNodes()) {
            container.removeChild(container.lastChild);
        }
        for (i=0;i<number;i++){
            // Append a node with a random text
            container.appendChild(document.createTextNode("Member " + (i+1)));
            // Create an <input> element, set its type and name attributes
            var input = document.createElement("input");
            input.type = "text";
            input.name = "member" + i;
            container.appendChild(input);
            // Append a line break
            container.appendChild(document.createElement("br"));
        }
    }

    <!-- jquerry to make bootstrap dropdown a clickable link-->
    jQuery(function($) {
        $('.dropdown > a').click(function(){
            location.href = this.href;
        });
    });