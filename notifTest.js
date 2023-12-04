document.addEventListener('DOMContentLoaded', function(){ // Wait until document is fully loaded before running script
        
    // Preventing redirect
    var createNotificationForm = document.querySelector(".createNotif-form");

    createNotificationForm.addEventListener('submit', function(event) { // adding event listener for when form is submitted

        event.preventDefault(); // prevents the page from reloading on submission

        var formData = new FormData(this);

        fetch('createNotification.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data); // logging data to console for debugging
            fetchAndDisplay();
        })
        .catch(error => {
            console.error('Error: ', error); // Logs error to console
        });
    });

    fetchAndDisplay();

    // Fetch and display notifications
    function fetchAndDisplay(){
        fetch('fetchNotifications.php')
        .then(response => response.json())
        .then(notifications => {
            const container = document.querySelector('.notifications-container');
            
            notifications.forEach(notification => {
                const notifElement = document.createElement('div'); // Creating notificatoin element
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

                container.appendChild(notifElement); // Adding notification to the div so it is displayed
            });
        })
        .catch(error => console.error('Error:', error));
    }
});