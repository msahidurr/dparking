(function ($) {
    "use strict";
    $(document).on("click", "#submitBtn", function () {
        axios.post(route('activation.active'), $('#licenseForm').serialize()).then(resData => {
            $('#licenseForm').find('.help-block').addClass('d-none');
            $('#licenseForm').find('.form-group').addClass('validate');
            if (resData.data == 1) {
                toast.fire({
                    icon: 'success',
                    title: 'Successfully activated',
                });
            }
            else if (resData.data == 0) {
                toast.fire({
                    icon: 'error',
                    title: 'Invalid code',
                });
            }
            else if (resData.data == 2) {
                toast.fire({
                    icon: 'info',
                    title: 'Already activated',
                });
            }
            else {
                toast.fire({
                    icon: 'error',
                    title: 'Something went wrong!',
                });
            }
        }).catch(failData => {
            if(failData.response.status == 422){
                $('#licenseForm').find('.help-block').addClass('d-none');
                $('#licenseForm').find('.form-group').addClass('validate');
                $.each(failData.response.data.errors, function (inputName, errors) {
                    let inputSelector = $(document).find('#licenseForm [name="' + inputName + '"]');
                    $(inputSelector).closest('.form-group').removeClass('error').addClass('error');
                    $(inputSelector).closest('.form-group').removeClass('validate');
                    $(inputSelector).closest('.form-group').find('.help-block').html(errors[0]);
                    $(inputSelector).closest('.form-group').find('.help-block').removeClass('d-none');
                });
            }
            else{
                toast.fire({
                    icon: 'error',
                    title: 'Something went wrong!',
                });
            }
        });
    });

    var toast = Swal.mixin({
        toast: true,
        icon: 'success',
        title: 'General Title',
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast'
        },
        position: 'top',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
})(jQuery);
