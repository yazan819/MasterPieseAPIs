// // Email Validation
// function validationEmail() {
//     let email = document.getElementById("email");
//     let emailError = document.getElementById("email_error");

//     if (!email.value.match(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/)) {
//         emailError.textContent = 'Please Enter a valid email address!';
//         return false;
//     } else {
//         emailError.textContent = '';
//         return true;
//     }
// }

// // Password validation
// function validationPass() {
//     let createField = document.getElementById("password").value;
//     let createError = document.getElementById("error_pass");
//     if (!createField.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[?!@#$%^&*])[A-Za-z\d@$!%*?&#]{8,}$/)) {
//         createError.textContent = "Password is not valid!";
//         return false;
//     } else {
//         createError.textContent = "";
//         return true;
//     }
// }

// // Password show and hide
// let showPass = document.getElementById("show_password");
// let passwordField = document.getElementById("password");
// showPass.addEventListener('click', function () {
//     if (passwordField.type === "password") {
//         showPass.classList.replace("fa-eye-slash", "fa-eye");
//         passwordField.type = "text";
//     } else {
//         showPass.classList.replace("fa-eye", "fa-eye-slash");
//         passwordField.type = "password";
//     }
// });

// // Submit
// var loginButton = document.getElementById("Login");
// loginButton.addEventListener('click', function (event) {
//     event.preventDefault();
//     let isEmailValid = validationEmail();
//     let isPassValid = validationPass();

//     if (isEmailValid && isPassValid) {
//         let email = document.getElementById("email").value;
//         let password = document.getElementById("password").value;

//         var user = {
//             email: email,
//             password: password
//         };

//         fetch('http://localhost/api/login_oop.php', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json'
//             },
//             body: JSON.stringify(user)
//         })
//             .then(response => {
//                 if (!response.ok) {
//                     throw new Error('Network response was not ok');
//                 }
//                 return response.json(); // Parse the response body as JSON
//             })
//             .then(data => {
//                 console.log(data);
//                 let idname = data.user_id;
//                 if (data.status === true) {
//                     if (data.role === 2) {
//                         sessionStorage.setItem("isLoggedIn", "true");
//                         sessionStorage.setItem("id", idname);
//                         window.location.href = "/JobPortal (1)/JobPortal/src/index.html";

//                     } else if (data.role === 1) {
//                         sessionStorage.setItem("isLoggedIn", "true");
//                         sessionStorage.setItem("id", idname);
//                         window.location.href = "/101-Admin-Dashboard-keyframe-effects/index.html";


//                     } else {
//                         alert('Error: Invalid user');
//                     }
//                 } else {
//                     alert('Error: Invalid stats');


//                 }
//             })

//             .catch(error => {
//                 console.error('There was a problem with the fetch operation:', error);
//                 // Display an error message on the page if needed
//             });
//     }
// });











document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');

    loginForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        const apiUrl = 'http://localhost/masterPieseAPIs/masterPieseAPIs/User/loginAndRegister/login.php';

        const data = {
            email: email,
            password: password
        };

        fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
            .then(response => response.json())
            .then(data => {
                if (data.STATUS) {
                    // Redirect based on user role
                    if (data.ROLE === 1) {
                        window.location.href = '/101-Admin-Dashboard-keyframe-effects/index.html';
                    } else if (data.ROLE === 2) {
                        window.location.href = '/New folder/index.html';
                    } else {
                        // Handle other roles as needed
                        alert('Unknown user role');
                    }
                } else {
                    alert('Login failed. Check your credentials.');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    });
});