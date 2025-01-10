var modal = document.getElementById("logout-modal");
var logoutButton = document.getElementById("logout-button");
var closeModal = document.getElementById("close-modal");
var cancelLogout = document.getElementById("cancel-logout");
var confirmLogout = document.getElementById("confirm-logout");

logoutButton.onclick = function () {
  modal.style.display = "block";
};

closeModal.onclick = function () {
  modal.style.display = "none";
};

cancelLogout.onclick = function () {
  modal.style.display = "none";
};

confirmLogout.onclick = function () {
  window.location.href = "logout.php";
};

window.onclick = function (event) {
  if (event.target === modal) {
    modal.style.display = "none";
  }
};

document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("logout-modal");
  const closeModal = document.getElementById("close-modal");
  const logoutButton = document.getElementById("logout-button");

  // Show modal
  logoutButton.addEventListener("click", () => {
    modal.style.display = "flex";
  });

  // Close modal when close button is clicked
  closeModal.addEventListener("click", () => {
    modal.style.display = "none";
  });

  // Close modal when clicking outside the modal content
  window.addEventListener("click", (event) => {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });
});
