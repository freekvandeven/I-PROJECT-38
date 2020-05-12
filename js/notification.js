
function pushNotificationToSeller (itemName) {

    document.write()
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
    } else if (Notification.permission === "granted") {
        var notification = new Notification("U heeft het product verkocht!");
    } else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(function (permission) {
            if (permission === "granted") {
                var notification = new Notification("U heeft het product " + itemName + " verkocht!");
            }
        });
    }
}

function pushNotificationToBuyer (itemName) {
    // checken of het de buyer is
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
    } else if (Notification.permission === "granted") {
        var notification = new Notification("U heeft het product gekocht!");
    } else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(function (permission) {
            if (permission === "granted") {
                var notification = new Notification("U heeft het product " + itemName + " gekocht!");
            }
        });
    }
}





