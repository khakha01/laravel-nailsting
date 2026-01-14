document.addEventListener('DOMContentLoaded', function () {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');

    if (!nameInput || !slugInput) return;

    nameInput.addEventListener('keyup', function () {
        slugInput.value = toSlug(this.value);
    });

    nameInput.addEventListener('blur', function () {
        slugInput.value = toSlug(this.value);
    });

    function toSlug(str) {
        return str
            .toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[đĐ]/g, 'd')
            .replace(/([^0-9a-z-\s])/g, '')
            .replace(/(\s+)/g, '-')
            .replace(/^-+|-+$/g, '');
    }
});
