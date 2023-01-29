// Register a change validator on first name field
let fname = document.getElementById("fname");
fname.addEventListener("blur", fNameHandler);

// Register a change validator on last name field
let lname = document.getElementById("lname");
lname.addEventListener("blur", lNameHandler);

// Register a change validator on password field
let pwd = document.getElementById("password");
pwd.addEventListener("blur", pwdHandler);

// Register a change validator on confirm password field
let cpwd = document.getElementById("confirm-password");
cpwd.addEventListener("blur", cpwdHandler);

// Register a change validator on avatar image field
let avatar = document.getElementById("profile-photo");
avatar.addEventListener("blur", avatarHandler);

//          - username
let username = document.getElementById("username");
username.addEventListener("blur", usernameHandler);

//          - date of birth
let dob = document.getElementById("date-of-birth");
dob.addEventListener("blur", dobHandler);


document.getElementById("reg-form").addEventListener("submit", validateSignup);
