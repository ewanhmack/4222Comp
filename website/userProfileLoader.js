document.addEventListener('DOMContentLoaded', function() {
    var userEmail = localStorage.getItem('userEmail');

    if (userEmail) {
        fetch(`getUserData.php?email=${encodeURIComponent(userEmail)}`)
        .then(response => response.json())
        .then(user => {
            if (user) {
                
                document.getElementById('usernameDisplay').textContent = user.username;


                var dobFormatted = '';
                if (user.dob) {
                    var dateParts = user.dob.split('-');
                    dobFormatted = `${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`;
                }

                var userDetailsHtml = 
                `<h3>Name: ${user.FirstName} ${user.Surname}</h3>` +
                `<h3>Username: ${user.username}</h3>` +
                `<h3>Email Address: ${user.email}</h3>` +
                `<h3>Password: <span id="userPassword">Protected</span>` +
                ` <button id="showPasswordBtn">Show Password</button></h3>` +
                `<h3>Date of Birth: ${dobFormatted}</h3>`;

                document.getElementById('userDetails').innerHTML = userDetailsHtml;


                document.getElementById('showPasswordBtn').addEventListener('click', function() {
                    var passwordSpan = document.getElementById('userPassword');
                    var showPasswordBtn = this; 
                    if (showPasswordBtn.textContent === 'Show Password') {
                        passwordSpan.textContent = user.password; // Show password
                        showPasswordBtn.textContent = 'Hide Password'; // Change button text
                    } else {
                        passwordSpan.textContent = 'Protected'; // Hide password again
                        showPasswordBtn.textContent = 'Show Password'; // Reset button text
                    }
                });
            } else {
                console.log('No user data found.');
                document.getElementById('userDetails').innerHTML = '<p>No user data found.</p>';
            }
        })
        .catch(error => console.error('Error fetching user data:', error));
    } else {
        console.log('No email stored in localStorage.');
        document.getElementById('userDetails').innerHTML = '<p>No user email found in localStorage.</p>';
    }
});
