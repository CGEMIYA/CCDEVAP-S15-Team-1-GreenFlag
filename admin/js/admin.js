document.addEventListener("DOMContentLoaded", () => {

    new DataTable("#usersTable");

});

document.addEventListener("DOMContentLoaded", function () {
    if(document.querySelector("#usersTable")){
        new DataTable("#usersTable");
    }
});

document.querySelectorAll(".viewBtn").forEach(button => {

    button.addEventListener("click", function(){

        let id = this.dataset.id;

        fetch("actions/users/fetch.php?id="+id)

        .then(response => response.json())

        .then(user => {

            document.getElementById("view_id").textContent = user.id;
            document.getElementById("view_name").textContent = user.full_name;
            document.getElementById("view_email").textContent = user.email;
            document.getElementById("view_role").textContent = user.role;
            document.getElementById("view_status").textContent = user.status;
            document.getElementById("view_created").textContent = user.created_at;

            new bootstrap.Modal(
                document.getElementById("viewUserModal")
            ).show();

        });

    });

});