// redirects the user to the volunteerprofile page or organizationprofile page based on their userType
function redirectToPage(role) {
    if (role === 'volunteer') {
        window.location.href = 'volunteerprofilepage.php';
    } else if (role === 'organization') {
        window.location.href = 'organisationprofilepage.php';
    } else {
        // Default redirection if the role doesn't match any specified roles
        window.location.href = 'homepage.php';
    }
}