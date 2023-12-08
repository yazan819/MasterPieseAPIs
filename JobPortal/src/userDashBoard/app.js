$(".card").on("click", function(){
    $(".detail").addClass("active");
});

$(".close-detail").on("click", function(){
    $(".detail").removeClass("active");
});

$(".menu-bar").on("click", function(){
    $(".sidebar").addClass("active");
});

$(".logo").on("click", function(){
    $(".sidebar").removeClass("active");
});





function fetchAndDisplayPosts() {
    fetch('http://localhost/MasterPieseAPIsGithub/MasterPieseAPIs/server/User/postsCrud/ReadAllPosts.php')
        .then(response => response.json())
        .then(posts => {
            displayPosts(posts); // Display all posts initially
        })
        .catch(error => console.error('Error fetching data:', error));
}

// Function to display posts
function displayPosts(posts) {
    posts.forEach(post => {
        const card = createCard(post); // Create card for each post
        document.getElementById('CardContainertwo').appendChild(card); // Append card to container
    });
}

// Function to create a card
function createCard(post) {
    const card = document.createElement('div');
    card.classList.add('card');

    card.innerHTML = `
        <div class="card-left blue-bg">
            <img src="${post.profile_picture}" alt="Profile Picture" class="profile-picture">
        </div>
        <div class="card-center">
            <h3 class="username"></h3>
            <p class="card-detail">Looking for: ${post.YourNeed}</p>
            <p class="card-detail">I know: ${post.YourProvide}</p>
            <p class="card-loc"><ion-icon name="location-outline"></ion-icon>abcd stereet</p>
        </div>
        <div class="card-right">
            <div class="card-tag">
                <h5>Division</h5>
                <button onclick="displayPostDetails(${post.PostID})">View</button>
            </div>
            <div class="card-salary">
                <p><b class="your-provide">${post.Username}</b><span></span></p>
            </div>
        </div>
    `;

    return card;
}

// Function to display post details
function displayPostDetails(postId) {
    fetch(`http://localhost/MasterPieseAPIsGithub/MasterPieseAPIs/server/User/postsCrud/ReadPost.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            PostID: postId
        })
    })
    .then(response => response.json())
    .then(post => {
        const detail = document.querySelector('.detail');

        detail.innerHTML = `
            <ion-icon class="close-detail" name="close-outline"></ion-icon>
            <div class="detail-header">
                <img src="${post.profile_picture}" alt="">
                <h2>${post.Username}</h2>
                <p>${post.YourNeed}</p>
            </div>
            <hr class="divider">
            <div class="detail-desc">
                <div class="about">
                    <h4>The Serves I provide</h4>
                    <p>${post.YourProvide}</p>
                    <a href="#">Read more</a>
                </div>
                <hr class="divider">
                <div class="qualification">
                    <h4>Job Description </h4>
                    <ul>
                        ${post.Description}
                    </ul>
                </div>
            </div>
            <hr class="divider">
            <div class="detail-btn">
                <button class="but-apply">Apply Now</button>
                <button class="but-save">Save job</button>
            </div>
        `;

        // Show the detail view
        detail.classList.add('active');
    })
    .catch(error => console.error('Error fetching post:', error));
}
// Function to filter and display posts based on search input
function filterPosts(searchInput , I_knew) {
    const url = 'http://localhost/MasterPieseAPIsGithub/MasterPieseAPIs/server/User/SkillSwapSearch/SkillSwapSearch.php';
    const data = {
        "I_need": searchInput,
        "I_knew": I_knew
    };

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(filteredPosts => {
        // Clear existing posts
        document.getElementById('CardContainertwo').innerHTML = '';
console.log(filteredPosts)
        // Display filtered posts
        displayPosts(filteredPosts);
    })
    .catch(error => console.error('Error filtering posts:', error));
}

// Event listener for search button
document.getElementById('searchButton').addEventListener('click', function() {
    const searchInput = document.getElementById('searchInput').value.trim(); // Get search input value
    if(searchInput==''){
       let I_knew = '';
    }else{
        I_knew =sessionStorage.getItem('proff');
    }
    filterPosts(searchInput,I_knew);
     // Filter posts based on search input
});

// Fetch and display all posts initially
fetchAndDisplayPosts();    



