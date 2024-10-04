document.addEventListener('DOMContentLoaded', function() {
    const reviewForm = document.getElementById('reviewForm');
    const userEmailInput = document.getElementById('userEmail');
    const emailFromStorage = localStorage.getItem('userEmail'); 

    // Set email input to stored email value for form submission
    if (emailFromStorage) {
        userEmailInput.value = emailFromStorage;
    } else {
        
    }

    reviewForm.addEventListener('submit', function(event) {
        event.preventDefault(); 

        const formData = new FormData(reviewForm);
        fetch('submitReview.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                throw new Error('Server returned an error on review submission.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("An error occurred. Please try again.");
        });
    });

    const reviewsContainer = document.getElementById('reviewsContainer');

    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    function fetchAndDisplayReviews(albumKey) {
        fetch(`getReviews.php?albumKey=${albumKey}`)
            .then(response => response.json())
            .then(reviews => {
                reviewsContainer.innerHTML = ''; 
                if (reviews && reviews.length > 0) {
                    reviews.forEach(review => {
                        const reviewElement = document.createElement('div');
                        reviewElement.className = 'review';
                        reviewElement.innerHTML = `
                            <h2>User: ${review.user}</h2>
                            <p>Rating:<span class="review-stars">${generateStars(review.rating)}</span> <span class="review-date">Date: ${review.date}</span></p>
                            <p>Comment: ${review.comment}</p>
                        `;
                        reviewsContainer.appendChild(reviewElement);
                    });                                  
                } else {
                    reviewsContainer.innerHTML = '<p>No reviews available.</p>';
                }
            })
            .catch(error => console.error('Error fetching reviews:', error));
    }
    

    function generateStars(rating) {
        let stars = '';
        for (let i = 0; i < 5; i++) {
            stars += i < rating ? '&#9733;' : '&#9734;'; 
        }
        return stars;
    }

    const albumKey = getQueryParam('key');
    if (albumKey) {
        fetchAndDisplayReviews(albumKey);
    } else {
        reviewsContainer.innerHTML = '<p>Album key not specified.</p>';
    }
});
