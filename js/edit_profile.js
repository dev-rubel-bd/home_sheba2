document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("edit-profile-form");

    form.addEventListener("submit", function (event) {
        // Validate name
        const name = document.getElementById("name").value.trim();
        if (name === "") {
            alert("Name cannot be empty.");
            event.preventDefault();
            return;
        }

        // Validate username
        const username = document.getElementById("username").value.trim();
        if (username === "") {
            alert("Username cannot be empty.");
            event.preventDefault();
            return;
        }

        // Validate email
        const email = document.getElementById("email").value.trim();
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            alert("Please enter a valid email address.");
            event.preventDefault();
            return;
        }

        // Validate profile picture size (optional)
        const profilePicture = document.getElementById("profile_picture").files[0];
        if (profilePicture && profilePicture.size > 2 * 1024 * 1024) { // 2 MB limit
            alert("Profile picture size must be less than 2 MB.");
            event.preventDefault();
        }
    });
});
