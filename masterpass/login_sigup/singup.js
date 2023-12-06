
// // User Name validation:
// function validationName() {
//     let nameInput = document.getElementById("username").value;
//     let nameError = document.getElementById("name_error");
//     if (nameInput.trim() === '') {
//         nameError.textContent = 'Username is required!';
//         return false;
//     } else {
//         nameError.textContent = '';
//         return true;
//     }
// }

// // Email Validation:
// function validationEmail() {
//     let emailInput = document.getElementById("email").value;
//     let emailError = document.getElementById("email_error");
//     if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(emailInput)) {
//         emailError.textContent = 'Please Enter a valid email address!';
//         return false;
//     } else {
//         emailError.textContent = '';
//         return true;
//     }
// }

// // Password validation:
// function validationCreate() {
//     let passwordInput = document.getElementById("password").value;
//     let createError = document.getElementById("create_error");
//     if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*[?!@#$%^&*])[A-Za-z\d@$!%*?&#]{8,}/.test(passwordInput)) {
//         createError.textContent = "Please enter at least 8 characters with a number, symbol, lowercase, and uppercase letters!";
//         return false;
//     } else {
//         createError.textContent = "";
//         return true;
//     }
// }

// // Confirm Password:
// function checkPassword() {
//     let password = document.getElementById("password").value;
//     let confirmPassword = document.getElementById("confirm-password").value;
//     let errorCheck = document.getElementById("confirm_error");

//     if (password.trim() === '') {
//         errorCheck.textContent = "Password is required!";
//         return false;
//     } else if (password !== confirmPassword) {
//         errorCheck.textContent = "Passwords don't match!";
//         return false;
//     } else {
//         errorCheck.textContent = "";
//         return true;
//     }
// }


// // Passwords show and hide:
// let showPass = document.getElementById("show_password");
// let passwordField = document.getElementById("password");
// showPass.addEventListener('click', function () {
//     if (passwordField.type === "password") {
//         showPass.classList.replace("fa-eye-slash", "fa-eye");
//         return (passwordField.type = "text");
//     }
//     else {
//         showPass.classList.replace("fa-eye", "fa-eye-slash")
//         passwordField.type = "password"
//     }
// })

// let showCon = document.getElementById("confirm_password");
// let confirmField = document.getElementById("confirm-password")
// showCon.addEventListener('click', function () {
//     if (confirmField.type === "password") {
//         showCon.classList.replace("fa-eye-slash", "fa-eye");
//         return (confirmField.type = "text")
//     }
//     else {
//         showCon.classList.replace("fa-eye", "fa-eye-slash");
//         confirmField.type = "password"
//     }
// })



// // Form Submission and Fetch API:
// document.getElementById("button").addEventListener("click", function (event) {
//     event.preventDefault();

//     let isValidName = validationName();
//     let isValidEmail = validationEmail();
//     let isValidPassword = validationCreate();
//     let isMatchingPassword = checkPassword();

//     if (isValidName && isValidEmail && isValidPassword && isMatchingPassword) {
//         const username = document.getElementById("username").value;
//         const email = document.getElementById("email").value;
//         const password = document.getElementById("password").value;

//         const user = {
//             username: username,
//             email: email,
//             password: password
//         };

//         fetch('http://localhost/masterPieseAPIs/masterPieseAPIs/loginAndRegister/register.php', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json'
//             },
//             body: JSON.stringify(user)
//         })
//             .then(response => {
//                 if (response.ok) {
//                     window.location.href = "login.html"; // Redirect upon successful submission
//                 } else {
//                     throw new Error('Network response was not ok.');
//                 }
//             })
//             .catch(error => {
//                 console.error('There was a problem with the fetch operation:', error);
//             });
//     }
// });






document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        // Fetch API to send data to the server
        fetch("http://localhost/masterPieseAPIs/masterPieseAPIs/loginAndRegister/register.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                username: document.getElementById("username").value,
                email: document.getElementById("email").value,
                password: document.getElementById("password").value,
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("User registered successfully!");
                // Optionally, you can redirect the user to another page or perform other actions.
            } else {
                alert("Error: " + data.error);
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
    });
});