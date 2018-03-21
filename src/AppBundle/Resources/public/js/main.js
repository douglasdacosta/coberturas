$(document).ready(function () {
    $('.pessoa_incluir').on('change', '', function (el) {
        url = "/ajaxGetAnimais/" + $(this).val();
        $.post(url,
                {},
                function (result) {
                    html = '';
                    $.each(result, function (a, data) {
                        html = html + '<option value="' + data.animal_id + '">' + data.animal_nome + '</option>';
                    });
                    $('.animal_incluir').html(html);
                }
        );
    });
});