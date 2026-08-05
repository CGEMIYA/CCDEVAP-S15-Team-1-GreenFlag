/* ============================================
   GREEN FLAG
   REGISTER
============================================ */

const registerForm = document.getElementById("registerForm");

const fullName = document.getElementById("fullName");

const email = document.getElementById("email");

const password = document.getElementById("password");

const confirmPassword = document.getElementById("confirmPassword");

const terms = document.getElementById("terms");

const emailMessage = document.getElementById("emailMessage");

const passwordMessage = document.getElementById("passwordMessage");

/* ============================================
   EMAIL VALIDATION
============================================ */

email.addEventListener("input", () => {

    const value = email.value.trim().toLowerCase();

    if (value === "") {

        emailMessage.textContent = "";

        emailMessage.className = "";

        return;

    }

    if (value.endsWith("@dlsu.edu.ph")) {

        emailMessage.textContent = "✓ Valid DLSU email.";

        emailMessage.className = "success";

    }

    else {

        emailMessage.textContent = "✗ Please use your DLSU email address.";

        emailMessage.className = "error";

    }

});

/* ============================================
   PASSWORD VALIDATION
============================================ */

function validatePasswords() {

    if (password.value === "" && confirmPassword.value === "") {

        passwordMessage.textContent = "";

        passwordMessage.className = "";

        return;

    }

    if (password.value.length < 8) {

        passwordMessage.textContent =
            "✗ Password must be at least 8 characters.";

        passwordMessage.className = "error";

        return;

    }

    if (password.value !== confirmPassword.value) {

        passwordMessage.textContent =
            "✗ Passwords do not match.";

        passwordMessage.className = "error";

        return;

    }

    passwordMessage.textContent =
        "✓ Passwords match.";

    passwordMessage.className = "success";

}

password.addEventListener("input", validatePasswords);

confirmPassword.addEventListener("input", validatePasswords);

/* ============================================
   FORM SUBMISSION
============================================ */

registerForm.addEventListener("submit", function (event) {

    if (fullName.value.trim() === "") {

        event.preventDefault();

        notifyError("Please enter your full name.");

        fullName.focus();

        return;

    }

    if (!email.value.trim().toLowerCase().endsWith("@dlsu.edu.ph")) {

        event.preventDefault();

        notifyError("Please use your DLSU email.");

        email.focus();

        return;

    }

    if (password.value.length < 8) {

        event.preventDefault();

        notifyError("Password must be at least 8 characters.");

        password.focus();

        return;

    }

    if (password.value !== confirmPassword.value) {

        event.preventDefault();

        notifyError("Passwords do not match.");

        confirmPassword.focus();

        return;

    }

    if (!terms.checked) {

        event.preventDefault();

        notifyError("Please agree to the Community Guidelines.");

        return;

    }

    // No preventDefault() here!
    // The form will now submit to PHP automatically.

});