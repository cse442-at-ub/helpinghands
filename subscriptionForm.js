document.addEventListener('DOMContentLoaded', function(){ // Wait until document is fully loaded before running script

    var subscriptionForm = document.querySelector('.subscription-form');

    subscriptionForm.addEventListener('submit', function(event) { // adding event listener for when form is submitted

        event.preventDefault(); // prevents the page from reloading on submission

        var formData = new FormData(this);

        fetch('subscribe.php', { // using fetch to send AJAX request
            method: 'POST', // using POST
            body: formData // attaching form data
        })

        .then(response => response.text()) // making sure response is in text

        .then(data => {
            alert(data) // Displays alert with the data echoed by subscribe.php
        })

        .catch(error => {
            console.error('Error: ', error); // Logs error to console
        });

    });

});