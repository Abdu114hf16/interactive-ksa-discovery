// Night Mode Toggle
function toggleNightMode() {
    document.body.classList.toggle('night-mode');
    var isNight = document.body.classList.contains('night-mode');
    localStorage.setItem('nightMode', isNight);
    var btn = document.querySelector('.night-toggle');
    if (btn) {
        btn.innerHTML = isNight ? '&#9788;' : '&#9790;';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    if (localStorage.getItem('nightMode') === 'true') {
        document.body.classList.add('night-mode');
        var btn = document.querySelector('.night-toggle');
        if (btn) btn.innerHTML = '&#9788;';
    }
});

// Gallery Filtering
function filterRegions() {
    var searchInput = document.getElementById('searchInput');
    var filterSelect = document.getElementById('filterSelect');
    var cards = document.querySelectorAll('.region-card');
    var countEl = document.getElementById('resultsCount');

    if (!searchInput || !cards.length) return;

    var searchTerm = searchInput.value.trim().toLowerCase();
    var filterValue = filterSelect ? filterSelect.value : 'الكل';
    var visible = 0;

    cards.forEach(function(card) {
        var name = card.getAttribute('data-name').toLowerCase();
        var category = card.getAttribute('data-category');

        var matchesSearch = name.includes(searchTerm);
        var matchesFilter = filterValue === 'الكل' || category === filterValue;

        if (matchesSearch && matchesFilter) {
            card.style.display = 'block';
            visible++;
        } else {
            card.style.display = 'none';
        }
    });

    if (countEl) {
        countEl.textContent = 'عدد النتائج: ' + visible;
    }
}

// Login Form Validation
function validateLoginForm(form) {
    var username = form.querySelector('#username');
    var password = form.querySelector('#password');
    var valid = true;

    clearErrors(form);

    if (username.value.trim() === '') {
        showError(username, 'يرجى إدخال اسم المستخدم');
        valid = false;
    }

    if (password.value.trim() === '') {
        showError(password, 'يرجى إدخال كلمة المرور');
        valid = false;
    }

    return valid;
}

// Add/Edit Form Validation
function validateContentForm(form) {
    var valid = true;
    clearErrors(form);

    var name = form.querySelector('#name');
    var category = form.querySelector('#category');
    var description = form.querySelector('#description');

    if (name && name.value.trim() === '') {
        showError(name, 'يرجى إدخال اسم المكان');
        valid = false;
    }

    if (category && category.value === '') {
        showError(category, 'يرجى اختيار التصنيف');
        valid = false;
    }

    if (description && description.value.trim() === '') {
        showError(description, 'يرجى إدخال الوصف');
        valid = false;
    }

    var mainImage = form.querySelector('#main_image');
    if (mainImage && mainImage.hasAttribute('required') && mainImage.files.length === 0) {
        showError(mainImage, 'يرجى اختيار الصورة الرئيسية');
        valid = false;
    }

    return valid;
}

function showError(input, message) {
    input.classList.add('error');
    var errorEl = input.parentNode.querySelector('.error-text');
    if (errorEl) {
        errorEl.textContent = message;
        errorEl.style.display = 'block';
    }
}

function clearErrors(form) {
    var inputs = form.querySelectorAll('.error');
    inputs.forEach(function(input) {
        input.classList.remove('error');
    });
    var errors = form.querySelectorAll('.error-text');
    errors.forEach(function(el) {
        el.style.display = 'none';
    });
}

// Delete Confirmation
function confirmDelete(id) {
    var overlay = document.getElementById('confirmOverlay');
    var confirmBtn = document.getElementById('confirmDeleteBtn');
    overlay.classList.add('show');

    confirmBtn.onclick = function() {
        window.location.href = 'delete.php?id=' + id;
    };
}

function closeConfirm() {
    var overlay = document.getElementById('confirmOverlay');
    overlay.classList.remove('show');
}
