(function ($) {
    "use strict";
    $(document).on('change', '#place_id', function () {
        let floor = floors.filter(val => val.place_id == $(this).val());
        let category = categories.filter(val => val.place_id == $(this).val());
        let html = '<option value="">All floor</option>';
        $.each(floor, function (ind, val) {
            html += `<option value="${val.id}">${val.name}</option>`;
        });

        $(document).find('#floor_id').html(html);

        html = '<option value="">All category</option>';
        $.each(category, function (ind, val) {
            html += `<option value="${val.id}">${val.type}</option>`;
        });

        $(document).find('#category_id').html(html);
    });

})(jQuery);

function printDiv() {
    var printContents = document.getElementById('printBlock').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    setTimeout(function () {
        window.print();
        document.body.innerHTML = originalContents;
    }, 500);

}