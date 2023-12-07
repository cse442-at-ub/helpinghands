document.addEventListener('DOMContentLoaded', function(){ // Wait until document is fully loaded before running script
    function fetchAndDisplay(){
        fetch('fetchNotifications.php')
        .then(response => response.json())
        .then(notifications => {
            const container = document.querySelector('.dropdown-content');

            notifications.forEach(notification => {
                const notifElement = document.createElement('a'); // Creating notification element
                notifElement.textContent = notification.message;

                // Marking notification as read when it is clicked
                notifElement.onclick = function() {
                    fetch('markNotificationAsRead.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ notificationID: notification.notificationID }) // converting notificationID to a JSON string and sending it to the server in the fetch request
                    });
                    notifElement.remove(); // removes the notification from the user's screen
                };
                container.appendChild(notifElement); // adding notification
            });
        })
        .catch(error => console.error('Error: ', error));
    }

    fetchAndDisplay();

});