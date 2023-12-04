document.addEventListener("DOMContentLoaded", function() {
    const postsContainer = document.getElementById('posts');

    fetch('http://localhost/masterPieseAPIs/Admin/postsCrud/ReadAllPosts.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        data.forEach(post => {
            const postDiv = document.createElement('div');
            postDiv.innerHTML = `
                <p>Post ID: ${post.PostID}</p>
                <p>User ID: ${post.UserID}</p>
                <p>Your Need: ${post.YourNeed}</p>
                <p>Your Provide: ${post.YourProvide}</p>
                <p>Description: ${post.Description}</p>
                <hr>
            `;
            postsContainer.appendChild(postDiv);
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
