jQuery(function($){
	$('.idade').mask('000');
	$('.data').mask('00/00/0000');
	$('.hora').mask('00:00:00');
	$('.data_hora').mask('00/00/0000 00:00:00');
	$('.cep').mask('00000-000');
	$('.phone').mask('0000-0000');
	$('.telefone').mask('(00) 0000-0000');
	$('.telefone-cel').mask('(00) 00000-0000');
	$('.phone_us').mask('(000) 000-0000');
	$('.mixed').mask('AAA 000-S0S');
	$('.cpf').mask('000.000.000-00', {reverse: true});
	$('.cnpj').mask('00.000.000/0000-00', {reverse: true});
	$('.dinheiro').mask('000.000.000.000.000,00', {reverse: true});
	$('.money2').mask("#.##0,00", {reverse: true, maxlength: false});
	$('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {translation: {'Z': {pattern: /[0-9]/, optional: true}}});
	$('.ip_address').mask('099.099.099.099');
	$('.uma_casa').mask('99999,0');
	$('.quatro_casas').mask('000,0000',{reverse: true});
	$('.tres_casas').mask('000,000',{reverse: true});
	$('.percent').mask('##0,00%', {reverse: true});
	
	$(document).on('blur','.checaDecimaisAdireita4casas',function(){
		if($(this).val().indexOf(',')<0)
		{
			valor=$(this).val()+',0000';
			$(this).val(valor);
		}
	});	
	$(document).on('blur','.checaDecimaisAdireita3casas',function(){
		if($(this).val().indexOf(',')<0)
		{
			valor=$(this).val()+',000';
			$(this).val(valor);
		}
	});	
});