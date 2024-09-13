$(document).ready(function () {
    let city = $('.cityList');
    let country = $('#country');
    let baseUrl = $('#baseUrl').val();
    baseUrl = baseUrl + '/ajaxCounterCity';
    country.select2();
    city.select2({
        ajax: {
            url: baseUrl,
            type: "GET",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
                    page: params.page || 1,
                    id: $('#country').find(':selected').val(),
                }
            },
            cache: false
        }
    });
    $('.select2').css('width', '100%');
});
