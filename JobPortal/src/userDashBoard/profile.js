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


function fetchUserDataAndPopulateForm(userID) {
    fetch('http://localhost/MasterPieseAPIsGithub/MasterPieseAPIs/server/Admin/usersCrud/ReadSpacificUser.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ UserID: userID }),
    })
    .then(response => response.json())
    .then(data => {
        // Populate form fields with user data
        document.getElementById('userName').innerText = data.Username;
        document.getElementById('ProfileImg').setAttribute('src', data.ProfilePictureURL);
        document.getElementById('ProfileImgTwo').setAttribute('src', data.ProfilePictureURL);
        document.getElementById('userEmail').innerText = data.Email;
        document.getElementById('userLocation').innerText = data.Location;
        document.getElementById('userBio').innerText = data.Bio;
        
        // Add event listener to the Edit profile button
        document.querySelector('.btn.btn-primary').addEventListener('click', function() {
            // Here you can handle the click event and use the userID
            // For example, redirect to an edit profile page with the userID
            window.location.href = 'editProfile.html?userid=' + userID;
            // Or perform any other action you want with the userID
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Call the function with the stored userID
document.addEventListener("DOMContentLoaded", function() {

    let userID = sessionStorage.getItem("userid");
    if(!userID)(
        userID=3
    )
    fetchUserDataAndPopulateForm(userID);
});







document.getElementById('ProfileLoction').addEventListener('click', function() {

    window.location.href = 'Profile.html';
});