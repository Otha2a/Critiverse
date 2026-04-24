const modal = document.getElementById("auth-modal");
const formTitle = document.getElementById("form-title");
const extraField = document.getElementById("extra-field");

document.getElementById("open-login").addEventListener("click", () => {
  modal.style.display = "flex";
  switchMode("login");
});

document.getElementById("open-signup").addEventListener("click", () => {
  modal.style.display = "flex";
  switchMode("signup");
});

document.getElementById("close-modal").addEventListener("click", () => {
  modal.style.display = "none";
});

function switchMode(mode) {
  if (mode === "login") {
    formTitle.textContent = "Connexion";
    extraField.style.display = "none";
  } else {
    formTitle.textContent = "Inscription";
    extraField.style.display = "block";
  }
}

document.getElementById("auth-form").addEventListener("submit", function(e) {
  e.preventDefault();

  if (formTitle.textContent === "Connexion") {
    console.log("Login");
  } else {
    console.log("Signup");
  }
});

window.addEventListener("click", (e) => {
  if (e.target === modal) {
    modal.style.display = "none";
  }
});