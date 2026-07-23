document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.editSpotBtn').forEach(function (button) {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            fetch('actions/spots/fetch.php?id=' + id)
                .then(function (response) { return response.json(); })
                .then(function (spot) {
                    document.getElementById('edit_spot_id').value = spot.id;
                    document.getElementById('edit_spot_name').value = spot.name || '';
                    document.getElementById('edit_spot_location').value = spot.location || '';
                    document.getElementById('edit_spot_description').value = spot.description || '';
                    document.getElementById('edit_spot_image').value = spot.image || '';
                    document.getElementById('edit_spot_hours').value = spot.hours || '';
                    document.getElementById('edit_spot_noise').value = spot.noise || 'Low';
                    document.getElementById('edit_spot_privacy').value = spot.privacy || 'Low';
                    document.getElementById('edit_spot_price').value = spot.price || 'Free';
                    new bootstrap.Modal(document.getElementById('editSpotModal')).show();
                });
        });
    });

    document.querySelectorAll('.editTagBtn').forEach(function (button) {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            fetch('actions/tags/fetch.php?id=' + id)
                .then(function (response) { return response.json(); })
                .then(function (tag) {
                    document.getElementById('edit_tag_id').value = tag.id;
                    document.getElementById('edit_tag_name').value = tag.tag_name || '';
                    new bootstrap.Modal(document.getElementById('editTagModal')).show();
                });
        });
    });
});
