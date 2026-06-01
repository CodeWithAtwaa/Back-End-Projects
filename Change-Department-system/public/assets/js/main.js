
const togglePassword = document.getElementById("togglePassword");
const passwordInput = document.querySelector(".password-input");

togglePassword.addEventListener("click", () => {
    const type =
        passwordInput.getAttribute("type") === "password" ? "text" : "password";
    passwordInput.setAttribute("type", type);
    // Toggle icon between eye and eye-slash
    togglePassword.classList.toggle("fa-eye-slash");
});
