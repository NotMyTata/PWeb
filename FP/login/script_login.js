let signup = document.querySelector(".signup");
let login = document.querySelector(".login");
let loginform = document.querySelector(".login-form");
let signupform = document.querySelector(".signup-form");

signup.addEventListener("click", () => {
    document.title = "Signup"
    login.classList.remove("btn-primary");
    signup.classList.add("btn-primary");
    signupform.classList.remove("visually-hidden");
    loginform.classList.add("visually-hidden");
});

login.addEventListener("click", () => {
    document.title = "Login"
    login.classList.add("btn-primary");
    signup.classList.remove("btn-primary");
    loginform.classList.remove("visually-hidden");
    signupform.classList.add("visually-hidden");
});