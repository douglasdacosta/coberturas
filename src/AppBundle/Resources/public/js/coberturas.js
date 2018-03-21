$(document).ready(function () {

    $('#valor, #parcelas').on('change', '', function (el) {

        url = "/ajaxCalculaParcelas/" + $('#parcelas').val() + "/" + $('#valor').val() + "/";
        $.post(url,
                {},
                function (result) {
                    $('#table-coberturas tbody').html(result.text_html)
                }, 'json'
                );

    });


    $('.salvar').on('click', '', function (el) {
        var parcela = $(this).data('parcela');
        cobertura = $(this).data('cobertura');
        data = $('#pagamento_'+parcela).val().replace(/\//g, '-');
        
        url = "/ajaxAlterarParcela/" + parcela + "/" + cobertura + "/" + data +"/";
        $.post(url,
                {},
                function (result) {
                    if(result.error){
                       alert(result.message); 
                       return false
                    }
                    alert(result.message);
                    $('.class_pago_'+parcela).addClass('fas fa-check pago');                    
                    $('#modal_alterar_'+parcela).modal('hide');
                    return true;
                }, 'json'
                );

    });
    
    $('.deletar').on('click', '', function (el) {
        var parcela = $(this).data('parcela');
        cobertura = $(this).data('cobertura');
      
        url = "/ajaxDeletarParcela/" + parcela + "/" + cobertura + "/";
        $.post(url,
                {},
                function (result) {
                    if(result.error){
                       alert(result.message); 
                       return false
                    }
                    alert(result.message);
                    $('#modal_alterar_'+parcela).modal('hide');
                    $('.tr_parcela_'+parcela).remove();
                    
                    return true;
                }, 'json'
                );

    });

    function divideValor(valor, parcela) {
        return parseFloat(Math.round(valor / parcela)).toFixed(2);

    }


});