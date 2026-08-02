/* ============================================
   GREEN FLAG
   LOGIN
============================================ */

const loginForm = document.getElementById("loginForm");

const emailInput = document.getElementById("email");

const passwordInput = document.getElementById("password");

const checkInput = document.getElementById("check");

/* ============================================
   FORM SUBMISSION
============================================ */

loginForm.addEventListener("submit", function (event) {

    const email = emailInput.value.trim();

    const password = passwordInput.value;

    /* ==========================
       Empty Fields
    ========================== */

    if (email === "" || password === "") {

        event.preventDefault();

        alert("Please complete all fields.");

        return;

    }

    /* ==========================
       DLSU Email Validation
    ========================== */

    if (!email.toLowerCase().endsWith("@dlsu.edu.ph")) {

        event.preventDefault();

        alert("Please use your DLSU email address.");

        emailInput.focus();

        return;

    }

    /* ==========================
       Password Length
    ========================== */

    if (password.length < 8) {

        event.preventDefault();

        alert("Password must be at least 8 characters.");

        passwordInput.focus();

        return;

    }

    
      

    // No event.preventDefault() here!
    // If everything is valid,
    // the browser submits the form to PHP automatically.

});

/*===============================
      Password show or hide
=============================*/
   if(checkInput){
      checkInput.addEventListener("change", function () {
         if (this.checked) {
            passwordInput.type = "text";
         } else {
            passwordInput.type = "password";
            }
      });
   }