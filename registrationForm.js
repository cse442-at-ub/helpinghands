document.addEventListener('DOMContentLoaded', function(){ // Wait until document is fully loaded before running script
    var registrationForms = document.querySelectorAll('.registration-form');


registrationForms.forEach(function(form) {

    form.addEventListener('submit', function(event) { // adding event listener for when form is submitted

        event.preventDefault(); // prevents the page from reloading on submission

        var formData = new FormData(this);
        var registerButton  = document.querySelector('.post-register');


        fetch('registerEvent.php', { // using fetch to send AJAX request 
            method: 'POST', // using POST
            body: formData // attaching form data
        })

        .then(response => response.text()) // making sure response is in text

        .then(data => {
            registerButton.innerHTML = data; // setting the button to display what is echoed by registerEvent.php
        })

        .catch(error => {
            console.error('Error: ', error); // Logs error to console
        });

    });
});

});