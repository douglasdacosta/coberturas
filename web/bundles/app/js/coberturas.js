$(document).ready(function () {

    $('#valor, #parcelas').on('change', '', function (el) {

        url = "/coberturas/web/ajaxCalculaParcelas/" + $('#parcelas').val() + "/" + $('#valor').val() + "/";
        $.post(url,
                {},
                function (result) {
                    $('#table-coberturas tbody').html(result.text_html)
                }, 'json'
                );

    });

    $(document).on('click', '.salvar_form', function (el) {
        
        if( $('#pessoa').val() == '') {
            $('#pessoa').focus();
            alert('Nenhuma pessoa encontrada');
            return false;
        }
        
        if( $('#animal').val() == '') {
            $('#animal').focus();
            alert('Nenhum animal encontrado');
            return false;
        }
        
        if( $('#garanhao').val() == '') {
            $('#garanhao').focus();
            alert('Nenhum garanhão encontrado');
            return false;
        }
        
        if( $('#table-coberturas tbody tr').length == 0) {
            $('#valor').focus();
            alert('Nenhuma parcela encontrada');
            return false;
        }
    });

    $('.salvar').on('click', '', function (el) {
        var parcela = $(this).data('parcela');
        cobertura = $(this).data('cobertura');
        data = $('#pagamento_'+parcela).val().replace(/\//g, '-');
        
        url = "/coberturas/web/ajaxAlterarParcela/" + parcela + "/" + cobertura + "/" + data +"/";
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
      
        url = "/coberturas/web/ajaxDeletarParcela/" + parcela + "/" + cobertura + "/";
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