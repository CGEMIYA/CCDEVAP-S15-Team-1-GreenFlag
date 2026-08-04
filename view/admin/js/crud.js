document.addEventListener('DOMContentLoaded', function () {
    function bindEditModal(selector, fetchUrl, fieldMap, modalId) {
        document.querySelectorAll(selector).forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                const id = this.getAttribute('data-id');

                fetch(fetchUrl + '?id=' + encodeURIComponent(id))
                    .then(function (response) {
                        if (!response.ok) {
                            throw new Error('Unable to load record');
                        }
                        return response.json();
                    })
                    .then(function (record) {
                        Object.entries(fieldMap).forEach(function ([key, elementId]) {
                            const element = document.getElementById(elementId);
                            if (!element) {
                                return;
                            }

                            const value = record[key] ?? '';
                            if (element.tagName === 'SELECT') {
                                element.value = value || '';
                            } else {
                                element.value = value || '';
                            }
                        });

                        const modal = new bootstrap.Modal(document.getElementById(modalId));
                        modal.show();
                    })
                    .catch(function () {
                        alert('Unable to load the record for editing.');
                    });
            });
        });
    }

    bindEditModal('.editUserBtn', '../../controller/admin/actions/users/fetch.php', {
        id: 'edit_id',
        full_name: 'edit_full_name',
        email: 'edit_email',
        role: 'edit_role',
        status: 'edit_status'
    }, 'editUserModal');

    bindEditModal('.editSpotBtn', '../../controller/admin/actions/spots/fetch.php', {
        id: 'edit_spot_id',
        name: 'edit_spot_name',
        location: 'edit_spot_location',
        description: 'edit_spot_description',
        image: 'edit_spot_image',
        hours: 'edit_spot_hours',
        noise: 'edit_spot_noise',
        privacy: 'edit_spot_privacy',
        price: 'edit_spot_price'
    }, 'editSpotModal');

    bindEditModal('.editTagBtn', '../../controller/admin/actions/tags/fetch.php', {
        id: 'edit_tag_id',
        tag_name: 'edit_tag_name'
    }, 'editTagModal');
});
