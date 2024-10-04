document.addEventListener('DOMContentLoaded', function () {
	let favoriteAlbumButton = document.getElementById('favouriteAlbumButton');
	let userDetails = document.getElementById('userDetails');
	let albumSelectElement = document.getElementById('albumSelect');
	let userEmail = localStorage.getItem('userEmail');
	
	if (!userEmail) {
		console.log("No user email found, please log in.");
		return;
	}
	
	// Fetch user data and update the favorite album selection
	fetch(`getUserData.php?email=${encodeURIComponent(userEmail)}`)
	.then(response => response.json())
	.then(userData => {
		if (userData && userData.favouriteAlbumId) {
			albumSelectElement.value = userData.favouriteAlbumId;
		} else {
			console.log("No favorite album set for this user.");
		}
	})
	.catch(error => {
		console.error('Failed to fetch user data:', error);
		userDetails.textContent = 'Unable to load user details, please try again later.';
	});
	
	// Handle the favorite album update process
	favoriteAlbumButton.addEventListener('click', function () {
		let selectedAlbumId = albumSelectElement.value;
		if (!selectedAlbumId) {
			console.error('No album selected');
			return;
		}
		
		let accountUpdate = {
			email: userEmail,
			favouriteAlbumId: selectedAlbumId
		};
		
		// Update the favorite album on the server
		fetch('updateAccounts.php', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify(accountUpdate)
		})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				console.log('Your favorite album has been updated successfully!');
			} else {
				userDetails.textContent = `Oops, something went wrong: ${data.error}`;
				console.error('Server error:', data.error);
			}
		})
		.catch(error => {
			userDetails.textContent = 'Sorry, we could not update your favorite album at this time.';
			console.error('Update error:', error);
		});
	});
});
