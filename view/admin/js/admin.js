document.addEventListener("DOMContentLoaded", function () {

    if (document.querySelector("#usersTable")) {
        new DataTable("#usersTable");
    }

    document.querySelectorAll(".editBtn").forEach(function (button) {
        button.addEventListener("click", function (event) {
            event.preventDefault();

            const id = this.getAttribute("data-id");

            fetch("actions/users/fetch.php?id=" + id)
                .then(function (response) { return response.json(); })
                .then(function (user) {
                    document.getElementById("edit_id").value = user.id;
                    document.getElementById("edit_full_name").value = user.full_name;
                    document.getElementById("edit_email").value = user.email;
                    document.getElementById("edit_role").value = user.role;
                    document.getElementById("edit_status").value = user.status;
                    document.getElementById("edit_password").value = "";

                    var modal = new bootstrap.Modal(document.getElementById("editUserModal"));
                    modal.show();
                });
        });
    });

    document.querySelectorAll(".deleteBtn").forEach(function (button) {
        button.addEventListener("click", function (event) {
            event.preventDefault();

            const id = this.getAttribute("data-id");

            if (confirm("Delete this user?")) {
                var form = document.createElement("form");
                form.method = "POST";
                form.action = "actions/users/delete.php";

                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "id";
                input.value = id;

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        });
    });

});

/*===============================
      Password show or hide
=============================*/
const checkInput = document.getElementById("check");
const passwordInput = document.getElementById("password");
   if(checkInput){
      checkInput.addEventListener("change", function () {
         if (checkInput.checked) {
            passwordInput.type = "text";
         } else {
            passwordInput.type = "password";
            }
      });
   }