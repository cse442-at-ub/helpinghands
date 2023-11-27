// redirects the user to the volunteerprofile page or organizationprofile page based on their userType
function redirectToPage(role,uid) {
    if (role === 'volunteer') {
        window.location.href = 'volunteerprofilepage.php?uid=' + uid.toString();
    } else if (role === 'organization') {
        window.location.href = 'organisationprofilepage.php?uid=' + uid.toString();
    } else {
        // Default redirection if the role doesn't match any specified roles
        window.location.href = 'homepage.php';
    }
}