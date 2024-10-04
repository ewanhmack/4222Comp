document.addEventListener('DOMContentLoaded', function() {
    // Check if user data exists in localStorage
    const userData = localStorage.getItem('userEmail');

    //Get hideable data
    const profileLink = document.getElementById('profileLink'); 
    const addAlbums = document.getElementById('addAlbums');
    const reviewSection = document.getElementById('reviewSection');
    if (userData) {
        // If user data exists, hide the login link and show the other links
        const loginLink = document.getElementById('loginLink');
        if (loginLink) loginLink.style.display = 'none';
        if (profileLink) profileLink.style.display = ''; 
        
        const user = JSON.parse(userData); 
        const usernameDisplay = document.getElementById('usernameDisplay');

        if (usernameDisplay && user.username) {
            usernameDisplay.textContent = `${user.username}`;
        }
    } else {
        // If user data does not exist, hide the profile link
        if (profileLink) profileLink.style.display = 'none';
        addAlbums.style.display = 'none';
        reviewSection.style.display = 'none';
    }
    
});
