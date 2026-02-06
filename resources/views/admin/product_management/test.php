
$(document).ready(function () {

    let savedData = localStorage.getItem('productForm');

    if (savedData) {
        let data = JSON.parse(savedData);

        $.each(data, function (key, value) {
            let field = $('[name="' + key + '"]');

            if (!field.length) return;

            if (field.attr('type') === 'checkbox') {
                field.prop('checked', value == 1);
            } else {
                field.val(value);
            }
        });
    }

});

  // 🔹 Convert FormData → Object (for localStorage)
            let formObject = {};
            formData.forEach((value, key) => {
                formObject[key] = value;
            });

            // 🔹 Save form data temporarily
            localStorage.setItem('productForm', JSON.stringify(formObject));
            localStorage.setItem('productId', response.product_id);
