<? die('RODRIGO GOLFETO DE QUEIROZ ::: rgolfeto@gmail.com'); ?>

<a href="javascript:;" id="btEnvia"></a>
<script>
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// VALIDAÇÃO
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$(function(){
	  $("#btEnvia").click(function(){
	  	var rea_atr_id		= $("#rea_atr_id").find('span').length;
		var age_nome_empresa	= $("#age_nome_empresa").val();
		var age_cpf				= $("#age_cpf").val();
		var age_cnpj			= $("#age_cnpj").val();
		var age_endereco 		= $("#age_endereco").val();
		var age_bairro 			= $("#age_bairro").val();
		var age_cep 			= $("#age_cep").val();
		var age_cidade 			= $("#age_cidade").val();
		var age_estado 			= $("#age_estado").val();
		var age_telefone 		= $("#age_telefone").val();
		var age_email	 		= $("#age_email").val();
		var alerta 				= '';
		
		if(rea_atr_id<='1'){ alerta+='* Selecione uma atração ou mais\n'; }
		if(age_nome_empresa=='' || age_nome_empresa=='Nome ou Empresa'){ alerta+='* Nome ou Empresa\n'; }
		if(age_endereco=='' || age_endereco=='Endereço'){ alerta+='* Endereço\n'; }
		if(age_cpf=='' && age_cnpj==''){ alerta+='* CPF/CNPJ\n'; }
		if(age_bairro=='' || age_bairro=='Bairro'){ alerta+='* Bairro\n'; }
		if(age_cep=='' || age_cep=='CEP'){ alerta+='* CEP\n'; }
		if(age_cidade=='' || age_cidade=='Cidade'){ alerta+='* Cidade\n'; }
		if(age_estado=='' || age_estado=='Estado'){ alerta+='* Estado\n'; }
		if(age_telefone=='' || age_telefone=='Telefone'){ alerta+='* Telefone\n'; }
		if(age_email == "E-mail" || age_email == ""){ alerta+='* E-mail\n'; }else if(IsEmail(age_email) == false){ alerta+='* Digite um e-mail válido\n'; }
		if(alerta==''){ document.getElementById('formAgendamento').submit(); }else{ alert('Preencha os campos corretamente\n\n'+alerta); }
	  });
	});
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// VALIDAÇÃO CONTATO
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$(function(){
		$("#btEnvia").click(function(){	
			var con_nome 			= $("#con_nome").val();	
			var con_email	 		= $("#con_email").val();
			var con_assunto 		= $("#con_assunto").val();
			var con_mensagem 		= $("#con_mensagem").val();
			var alerta 				= '';			
			
			if(con_nome=='' || con_nome=='NOME'){ alerta+='* Nome\n'; }
			if(con_email == '' || con_email == 'E-MAIL'){ alerta+='* E-mail\n'; }else if(IsEmail(con_email) == false){ alerta+='* Digite um e-mail válido\n'; }
			if(con_assunto=='' || con_assunto=='ASSUNTO'){ alerta+='* Assunto\n'; }
			if(con_mensagem=='' || con_mensagem=='MENSAGEM'){ alerta+='* Mensagem\n'; }
			if(alerta==''){ document.getElementById('formFaleConosco').submit(); }else{ alert('Preencha os campos corretamente\n\n'+alerta); }
		});
	});		
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// RECUPERAÇÃO DE DADOS VIA JSON
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$.ajax({
		type: "POST",
		url: "mestre.php",
		dataType: "html",
		success: function(result){
			var data = JSON.parse(result);
			console.log(data.nome);
			console.log(data.idade);
		}
	});
	<?php
	$resultado = array('nome'=>'Rodrigo Golfeto','idade'=>'23');
	echo json_encode($resultado);
	?>
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// VALIDAÇÃO CONTATO JS + JQUERY + PHP
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function enviarContato(){

		$('.bt-enviar').addClass('carregando');

		var campo_nome 		= $('#campo_nome').val();
		var campo_email	 	= $('#campo_email').val();
		var campo_assunto 	= $('#campo_assunto').val();
		var campo_mensagem 	= $('#campo_mensagem').val();
		var validacao 		= '';

		if(campo_nome==''){ validacao+='&campo_nome'; }
		if(campo_email=='' || IsEmail(campo_email)==false){ validacao+='&campo_email'; }
		if(campo_assunto==''){ validacao+='&campo_assunto'; }
		if(campo_mensagem==''){ validacao+='&campo_mensagem'; }

		if(validacao==''){
			$.ajax({
				type: "POST",
				data: { campo_nome:campo_nome,campo_email:campo_email,campo_assunto:campo_assunto,campo_mensagem:campo_mensagem },
				url: "acoes/enviarContato.php",
				dataType: "html",
				success: function(result){
					dados = result.split(':))');
					if(dados[0]=='0'){ // VALIDAÇÃO
						dados2 = dados[2].split('&');
						for(i=0;i<=dados2.length;i++){ if(dados2[i]!=''){ $('#'+dados2[i]).addClass('invalido'); } }
						$(".invalido").focus(function(){ $(this).removeClass('invalido'); });
						$('.mensagem').html(dados[1]).addClass('aberto').addClass('erro');
					}else if(dados[0]=='1'){ // ENVIADO
						$('.mensagem').html(dados[1]).addClass('aberto').addClass('sucesso');
					}else if(dados[0]=='2'){ // FALHA
						$('.mensagem').html(dados[1]).addClass('aberto').addClass('erro');
					}else{
						$('.mensagem').html(result).addClass('aberto').addClass('erro');
					}
					setTimeout(function(){
						$('.mensagem').html('').removeClass('aberto').removeClass('erro').removeClass('sucesso');
					},6000);
					$('.bt-enviar').removeClass('carregando');
				}
		   	});
		}else{
			dados = validacao.split('&');
			for(i=0;i<=dados.length;i++){ if(dados[i]!=''){ $('#'+dados[i]).addClass('invalido'); } }
			$(".invalido").focus(function(){ $(this).removeClass('invalido'); });
			$('.bt-enviar').removeClass('carregando');
		}
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// ACENTUAÇÃO COM ALERTS
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function acentuarAlerts(mensagem){
		//Paulo Tolentino
		//Usar dessa forma: alert(acentuarAlerts('teste de acentuação, essência, carência, âê.'));
		mensagem = mensagem.replace('á', '\u00e1');
		mensagem = mensagem.replace('à', '\u00e0');
		mensagem = mensagem.replace('â', '\u00e2');
		mensagem = mensagem.replace('ã', '\u00e3');
		mensagem = mensagem.replace('ä', '\u00e4');
		mensagem = mensagem.replace('Á', '\u00c1');
		mensagem = mensagem.replace('À', '\u00c0');
		mensagem = mensagem.replace('Â', '\u00c2');
		mensagem = mensagem.replace('Ã', '\u00c3');
		mensagem = mensagem.replace('Ä', '\u00c4');
		mensagem = mensagem.replace('é', '\u00e9');
		mensagem = mensagem.replace('è', '\u00e8');
		mensagem = mensagem.replace('ê', '\u00ea');
		mensagem = mensagem.replace('ê', '\u00ea');
		mensagem = mensagem.replace('É', '\u00c9');
		mensagem = mensagem.replace('È', '\u00c8');
		mensagem = mensagem.replace('Ê', '\u00ca');
		mensagem = mensagem.replace('Ë', '\u00cb');
		mensagem = mensagem.replace('í', '\u00ed');
		mensagem = mensagem.replace('ì', '\u00ec');
		mensagem = mensagem.replace('î', '\u00ee');
		mensagem = mensagem.replace('ï', '\u00ef');
		mensagem = mensagem.replace('Í', '\u00cd');
		mensagem = mensagem.replace('Ì', '\u00cc');
		mensagem = mensagem.replace('Î', '\u00ce');
		mensagem = mensagem.replace('Ï', '\u00cf');
		mensagem = mensagem.replace('ó', '\u00f3');
		mensagem = mensagem.replace('ò', '\u00f2');
		mensagem = mensagem.replace('ô', '\u00f4');
		mensagem = mensagem.replace('õ', '\u00f5');
		mensagem = mensagem.replace('ö', '\u00f6');
		mensagem = mensagem.replace('Ó', '\u00d3');
		mensagem = mensagem.replace('Ò', '\u00d2');
		mensagem = mensagem.replace('Ô', '\u00d4');
		mensagem = mensagem.replace('Õ', '\u00d5');
		mensagem = mensagem.replace('Ö', '\u00d6');
		mensagem = mensagem.replace('ú', '\u00fa');
		mensagem = mensagem.replace('ù', '\u00f9');
		mensagem = mensagem.replace('û', '\u00fb');
		mensagem = mensagem.replace('ü', '\u00fc');
		mensagem = mensagem.replace('Ú', '\u00da');
		mensagem = mensagem.replace('Ù', '\u00d9');
		mensagem = mensagem.replace('Û', '\u00db');
		mensagem = mensagem.replace('ç', '\u00e7');
		mensagem = mensagem.replace('Ç', '\u00c7');
		mensagem = mensagem.replace('ñ', '\u00f1');
		mensagem = mensagem.replace('Ñ', '\u00d1');
		mensagem = mensagem.replace('&', '\u0026');
		mensagem = mensagem.replace('\'', '\u0027');
	
		return mensagem;
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// SISTEMA DE BUSCA POR URL
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	$(function(){
		$("#btBusca").click(function(){
		
			var bus_estdo 	= $("#anu_estado").val();
			var bus_cidde 	= $("#selCidade").val();
			var bus_setor 	= $("#segmento").val();
			var bus_ativi	= $("#idatividade").val();
			var bus_valr1	= $("#valor1").val();
			var bus_valr2 	= $("#valor2").val();
			var bus_plvra	= $("#key").val();
			var alerta 		= '';
			
			if(bus_estdo=='Selecione' || bus_estdo==''){ var bus_estdo = 'null'; }
			if(bus_cidde=='Selecione' || bus_cidde==''){ var bus_cidde = 'null'; }
			if(bus_setor=='Selecione' || bus_setor==''){ var bus_setor = 'null'; }
			if(bus_ativi=='Selecione' || bus_ativi==''){ var bus_ativi = 'null'; }
			if(bus_valr1=='Mínimo' || bus_valr1==''){ var bus_valr1 = 'null'; }
			if(bus_valr2=='Máximo' || bus_valr2==''){ var bus_valr2 = 'null'; }
			if(bus_plvra==''){ var bus_plvra = 'null'; }
			
			if(bus_estdo=='null' && bus_cidde=='null' && bus_setor=='null' && bus_ativi=='null' && bus_valr1=='null' && bus_valr2=='null' && bus_plvra=='null'){
				alert('Informe pelo menos um parametro de busca');
			}else{
				window.open('<?=SITE?>empresas/'+bus_estdo+'/'+bus_cidde+'/'+bus_setor+'/'+bus_ativi+'/'+bus_valr1+'/'+bus_valr2+'/'+bus_plvra+'/', '_self');
			}
		});
	});
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// DETECTA ENTER
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function detectaEnter(tecla){
		var keyCode = tecla.keyCode ? tecla.keyCode : tecla.which ? tecla.which : tecla.charCode;
		if(keyCode==13){
			//AÇÃO
			alert('oi');
			//focar -> $("#campo_cpf").focus();
		}
	}
	//USO
	//<input type="text" id="campo" name="campo" onkeypress="detectaEnter(event);" />
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// ADICIONAR E REMOVER CLASSES
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	$("p:first").addClass("intro");
	$("p:first").removeClass("intro");
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// SIMULAR CLICK
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	document.getElementById('btBuscaEmpresas').click();
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// ALTERAR INFORMAÇÕES
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$('#identificador').html('conteudo');
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// ADICIONAR INFORMAÇÕES INFORMAÇÕES
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$('#identificador').append('conteudo');
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// REDIRECIONAMENTO TEMPORÁRIO
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$(function(){ 
		var count = 20;
		var countdown = setInterval(function(){
			$("#count").html(count);
			if(count == 0){
				clearInterval(countdown);
				window.location.href = "<?=SITE?>"
			}
			count--;
		}, 1000);
	});
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// formatNumber
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function formatNumber(number){
		var number = number.toFixed(2) + '';
		var x = number.split('.');
		var x1 = x[0];
		var x2 = x.length > 1 ? ',' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + '.' + '$2');
		}
		return x1;
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// MODELO DE AJAX
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$.ajax({
		type: "POST",
		data: { campo1:campo1,campo2:campo2 },
		url: "acoes/nomeDoArquivo.php",
		dataType: "html",
		success: function(result){
			if(result=='1'){
				alert('ok');
			}else{
				alert('erro');
			}
		}
	});
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// AJAX PHP
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$.ajax({						
		type: "POST",
		data: { campo_veiculo:campo_veiculo,campo_editoria:campo_editoria,campo_jornalistas:campo_jornalistas,campo_email:campo_email },
		url: "acoes/enviarCredenciamento.php",
		dataType: "html",
		success: function(result){
			alert(result);
		}
   	});
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// CLICK
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$(".campo-invalido").click(function(){
		$(this).removeClass('campo-invalido');
	});
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// FOCUS
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$(".campo-invalido").focus(function(){
		$(this).removeClass('campo-invalido');
	});
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


</script>



<?

	############################################################################################################################################
	//GETS URL AMIGÁVEL
	############################################################################################################################################
	echo 'GET0: '.$gets[0].' <br />';
	echo 'GET1: '.$gets[1].' <br />';
	echo 'GET2: '.$gets[2].' <br />';
	echo 'GET3: '.$gets[3].' <br />';
	echo 'GET4: '.$gets[4].' <br />';
	echo 'GET5: '.$gets[5].' <br />';
	############################################################################################################################################
	############################################################################################################################################



	############################################################################################################################################
	//LISTA COM PAGINAÇÃO
	############################################################################################################################################
	// CONFIGURAÇÕES
	$tabela = "tag_noticias"; //Nome da Tabela
	$idTb 	= "not";//ID da tabela
	$condic = "AND ".$idTb."_ativo='1' AND ".$idTb."_data<=NOW()"; //Condição na consulta
	$ordena = "ORDER BY ".$idTb."_data DESC"; //Ordenar
	$max 	= 5; //QTDE DE PRODUTO POR PÁGINA

	$sql = "SELECT * FROM ".$tabela." WHERE 1=1 ".$condic;
	$res = $conn->consulta($sql);
	$tot = $conn->conta($res);
	$pag = $gets[1];
	if(!isset($pag) || $pag<1){ $pag=1; }
	$ini = ($pag * $max) - $max;
	$sql = "SELECT * FROM ".$tabela." WHERE 1=1 ".$condic." ".$ordena." LIMIT $ini, $max";
	$res = $conn->consulta($sql);
	$total = $conn->conta($res);
	while($lin=$conn->busca($res)){
		//CONTEÚDO DA LISTA AQUI
	}
	?>
	
    <!-- USANDO A FUNÇÃO DE PAGINAÇÃO -->        
    <?=usarPaginacao($pag,$tot,$max,'noticias',3); ?>
    
	<?     
    function usarPaginacao($pag,$total,$maximo,$arq,$links){
        $paginacao='';
        if($total>$maximo):
            $paginacao = '<div class="div-paginacao">';
            $pags=ceil($total/$maximo); $ant=$pag-1; $prox=$pag+1; $pagina=$pags-$pag; $pagina2=$pags-$pag; 
            if($pag>$pags){ $paginacao.='<script language="javascript">window.location="'.$arq.'/'.$pags.'";</script>'; } 
            if($pag<=1){  }else{ $paginacao.='<a href="'.$arq.'/'.$ant.'"><div>&lt;</div></a>'; } 
            if($pag>=6){ $paginacao.='<a href="'.$arq.'/1">1</a>...'; } 
            if($pag==5){ $paginacao.='<a href="'.$arq.'/1">1</a>'; } 
            for($i = $pag - $links; $i <= $pag - 1; $i++){ if($i <= 0){}else{ $paginacao.='<a href="'.$arq.'/'.$i.'">'.$i.'</a>'; } } 
            $paginacao.='<a class="marcado">'.$pag.'</a>';  for($i = $pag + 1; $i <= $pag + $links; $i++){ if($i > $pags){ }else{ $paginacao.='<a href="'.$arq.'/'.$i.'">'.$i.'</a>'; } } 
            if($pagina>=5){ $paginacao.='...<a href="'.$arq.'/'.$pags.'">'.$pags.'</a>'; } if($pagina==4){ $paginacao.='<a href="'.$arq.'/'.$pags.'">'.$pags.'</a>'; } 
            if($pag>=$pags){ }else{ $paginacao.='<a href="'.$arq.'/'.$prox.'"><div>&gt;</div></a>'; }
            $paginacao.='</div>';
        endif;
        return $paginacao;	
    }
	############################################################################################################################################
	############################################################################################################################################



	############################################################################################################################################
	//SUBSTITUIR PALAVRAS, CARACTERES, ETC.
	############################################################################################################################################
	$substituir = array('(',')','.',',','-','|','+','*','/','\\','"',"'",' ');
	echo str_replace($substituir,'','r*o-d"rigo');
	############################################################################################################################################
	############################################################################################################################################



	############################################################################################################################################
	//TIRAR AS TAGS HTML DE UMA VARIÁVEL
	############################################################################################################################################
	strip_tags($lin['not_texto']);
	############################################################################################################################################
	############################################################################################################################################



	############################################################################################################################################
	//DIRETÓRIOS
	############################################################################################################################################
	echo ("Retorna o domínio do servidor ".$_SERVER['SERVER_NAME']);
	echo ("Retorna o path do arquivo onde está sendo executado ".$_SERVER['PHP_SELF']);
	echo ("Retorna o path do pasta onde está sendo executado ".$_SERVER['DOCUMENT_ROOT']);
	echo ("Retorna o path do arquivo onde está sendo executado o script ".$_SERVER['SCRIPT_FILENAME']);
	echo ("Retorna o path e nome do arquivo que está executando ".$_SERVER['SCRIPT_NAME']);
	$path = $_SERVER['SCRIPT_FILENAME'];
	$path_parts = pathinfo($path);
	echo ("retorna o path absoluto do diretório no servidor ".$path_parts['dirname']);
	echo ("retorna o nome do arquivo com extensão ".$path_parts['basename']);
	echo ("retorna a extensão do arquivo ".$path_parts['extension']);
	echo ("retorna o nome do arquivo sem extensão ".$path_parts['filename']);
	############################################################################################################################################
	############################################################################################################################################



	####################################################################################################################################################################
	// Enviar o contato por email
	####################################################################################################################################################################
	if(!empty($_POST) && $_POST['acao']=='acao'):
			
		?><html><head><title>Enviando...</title></head><body></body></html><?
		
		// Verifica qual é o sistema operacional do servidor para ajustar o cabeçalho de forma correta. Não alterar
		if(PHP_OS == "Linux") $quebra_linha = "\n"; // Se for Linux
		elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows
		
		// Passando os dados obtidos pelo formulário para as variáveis abaixo
		$nomeremetente     	= 'CAÇA TALENTOS';
		
		$emailsender       	= "contato@cacatalentosiel.com.br";
		$emailremetente    	= "contato@cacatalentosiel.com.br";
		$emaildestinatario 	= "rodrigo@tag3.com.br";
		$assunto 		   	= 'CAÇA TALENTOS - CONTATO';
		
		$comcopia          	= '';
		$comcopiaoculta    	= '';
		
		$con_nome 			= utf8_decode(trim($_POST['con_nome']));// OBRIGATÓRIO
		$con_email 			= utf8_decode(trim($_POST['con_email']));// OBRIGATÓRIO
		$con_assunto 		= utf8_decode(trim($_POST['con_assunto']));
		$con_mensagem 		= utf8_decode(trim($_POST['con_mensagem']));
		
		
		################################################################################################################################################################################
		// CONTEÚDO DO E-MAIL
		################################################################################################################################################################################
		$mensagemHTML= '<div style="width:595px;margin:0 auto;padding:20px 0;"><table cellpadding="0" cellspacing="0" width="595" style="margin:0 auto;"><tr><td align="center" style="padding:5px 0;font-size:16px;line-height:16px;"><b>'.$assunto.'</b></td></tr><tr><td colspan="2"><div style="padding:20px 0;font-size:11px;line-height:15px;">';
		$mensagemHTML.='<b>Nome:</b> '.$con_nome.'<br />';
		$mensagemHTML.='<b>E-mail:</b> '.$con_email.'<br />';
		if($con_assunto): $mensagemHTML.='<b>Assunto:</b> '.$con_assunto.'<br />'; endif;
		if($con_mensagem): $mensagemHTML.='<b>Mensagem:</b> '.$con_mensagem.'<br />'; endif;
		$mensagemHTML.='</div></td></tr></table></div>';
		################################################################################################################################################################################
		################################################################################################################################################################################
		
		// Montando o cabeçalho da mensagem
		$headers = "MIME-Version: 1.1".$quebra_linha;
		$headers .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha;
		// Perceba que a linha acima contém "text/html", sem essa linha, a mensagem não chegará formatada.
		$headers .= "From: ".trim($con_nome)." <".trim($con_email).">".$quebra_linha;
		$headers .= "Return-Path: ".$nomeremetente."  <".$emailsender.">".$quebra_linha;
		// Esses dois "if's" abaixo são porque o Postfix obriga que se um cabeçalho for especificado, deverá haver um valor.
		
		// Se não houver um valor, o item não deverá ser especificado.
		if(strlen($comcopia) > 0) $headers .= "Cc: ".$comcopia.$quebra_linha;
		if(strlen($comcopiaoculta) > 0) $headers .= "Bcc: ".$comcopiaoculta.$quebra_linha;
		$headers .= "Reply-To: ".trim($con_email).$quebra_linha;
		// Note que o e-mail do remetente será usado no campo Reply-To (Responder Para)

		try {
		  // Enviando a mensagem
		  @$envio = mail($emaildestinatario, $assunto, $mensagemHTML, $headers, "-r". $emailsender);
		  if($envio == 1){ die('<script>alert("Enviado com sucesso!");window.open("'.SITE.'", "_self");</script>'); //$emaildestinatario
		  }else{ die('<script>alert("Email não enviado, tente novamente!");window.open("'.SITE.'contato", "_self");</script>'); }
		}
		catch (Exception $e) { die('<script>alert("Email não enviado, tente novamente!");window.open("'.SITE.'contato", "_self");</script>'); }
		/**/
	endif;	
	####################################################################################################################################################################
	####################################################################################################################################################################



	####################################################################################################################################################################
	// PADRÃOS DE EMAIL SIMPLES
	####################################################################################################################################################################
	if(PHP_OS == "Linux") $quebra_linha = "\n"; //Se for Linux
	elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows
	
	$contato_sender		= 'contato@tag3.com.br';//SENDER
	$contato_remetente	= 'contato@tag3.com.br'; //QUEM ESTÁ ENVIANDO
	$contato_destino 	= "rgolfeto@gmail.com";//QUEM VAI RECEBER
	$comcopia          	= 'pedro@tag3.com.br,rogerio@tag3.com.br';
	$comcopiaoculta    	= 'rodrigo_golfeto@hotmail.com';

	$contato_site		= SITE;//CAMINHO DO SITE
	$contato_nome_site	= 'NOME DO SITE';//NOME DO SITE
	$contato_titulo		= 'CONTATO';//TÍTULO DO CONTATO
	$contato_subtit		= 'Segue os detalhes do contato realizado no site.';//SUBTITULO DO CONTATO
	$contato_imagem		= 'imagens/topo-email.jpg';//400x100
	$contato_nome		= strip_tags('Rodrigo Golfeto de Queiroz');//NOME DO CONTATO
	$contato_email		= strip_tags('rodrigo@tag3.com.br');//EMAIL DO CONTATO
	$contato_assunto	= strip_tags('Vivamus in erat ut urna');//ASSUNTO DO CONTATO
	$contato_mensagem	= strip_tags(nl2br('Donec sodales sagittis magna. Praesent venenatis metus at tortor pulvinar varius. Cras non dolor. Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Aliquam eu nunc.'));
	$contato_cor_borda	= '#595959';//RODAPÉ DO CONTEÚDO
	$contato_txt_rodape	= 'Esta mensagem foi enviada através do formulário de contato.';//INSTRUÇÃO DO E-MAIL
	
	################################################################################################################################################################################
	//CONTEÚDO DO E-MAIL
	################################################################################################################################################################################
	$mensagemHTML = '<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:18px;color:#000000;"><tr><td align="center" style="padding:5px 0;"><img src="'.$contato_imagem.'" alt="" width="400" height="100" usemap="#Map2" style="display:block" /></td></tr><tr><td style="border-bottom:1px solid #CCC;">&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td align="center" valign="middle"><b style="font-size:18px;">'.$contato_titulo.'</b></td></tr><tr><td>&nbsp;</td></tr><tr><td align="center" valign="middle">'.$contato_subtit.'</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td style="font-size:13px;"><b>Nome:</b> '.$contato_nome.'<br /><b>E-mail:</b> '.$contato_email.'<br /><b>Assunto:</b> '.$contato_assunto.'<br /><br /><b>Mensagem:</b><br />'.str_replace('\n','<br>',$contato_mensagem).'</td></tr><tr><td>&nbsp;</td></tr><tr>';
	$mensagemHTML.= '<td style="border-bottom:2px solid '.$contato_cor_borda.';">&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td><div align="center" style="font-size:12px;color:#000;"><u>'.$contato_txt_rodape.'</u></div></td></tr></table><map name="Map2" id="Map2"><area shape="rect" coords="-1,-3,243,128" href="'.$contato_site.'" target="_blank" /></map>';
	################################################################################################################################################################################

	$headers  = 'MIME-Version: 1.1'.$quebra_linha;
	$headers .= 'Content-type: text/html; charset=iso-8859-1'.$quebra_linha;
	$headers .= 'From: '.trim($contato_nome_site).' <'.trim($contato_remetente).'>'.$quebra_linha;
	$headers .= 'Return-Path: '.$contato_nome_site.' <'.trim($contato_remetente).'>'.$quebra_linha;
	if(strlen($comcopia)>0) $headers .= 'Cc: '.$comcopia.$quebra_linha;
	if(strlen($comcopiaoculta)>0) $headers.='Bcc: '.$comcopiaoculta.$quebra_linha;
	$headers .= 'Reply-To: '.trim($contato_email).$quebra_linha;
	
	@$enviou=mail($contato_destino,$contato_assunto,$mensagemHTML,$headers,"-r".$contato_sender);
	
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>TESTE TAG3</title>
		</head>
		<body>        
			<? if($enviou): echo 'Enviado com sucesso.'; else: echo 'Erro ao enviar, tente novamente.'; endif; ?>
		</body>
	</html>
	<?
	####################################################################################################################################################################
	//FIM PADRÃO E-MAIL
	####################################################################################################################################################################



	####################################################################################################################################################################
	// PADRÃOS DE EMAIL - phpmailer
	####################################################################################################################################################################
	// CONFIGURAÇÕES
	###########################################################################################################
	$contato_site		= SITE;
	$contato_titulo		= 'CONTATO';
	$contato_subtit		= 'Segue os detalhes do contato realizado no site.';
	$contato_imagem		= 'imagens/logo-email.jpg';//400x100
	$contato_nome		= strip_tags('Rodrigo Golfeto de Queiroz');
	$contato_email		= strip_tags('rodrigo@tag3.com.br');
	$contato_assunto	= strip_tags('Vivamus in erat ut urna');
	$contato_mensagem	= strip_tags(nl2br('Donec sodales sagittis magna. Praesent venenatis metus at tortor pulvinar varius. Cras non dolor. Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Aliquam eu nunc.'));
	$contato_cor_borda	= '#595959';
	$contato_txt_rodape	= 'Esta mensagem foi enviada através do formulário de contato';
	$mensagemHTML 		= utf8_decode('<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:18px;color:#000000;"><tr><td align="center" style="padding:5px 0;"><img src="'.$contato_imagem.'" alt="" width="400" height="100" usemap="#Map2" style="display:block" /></td></tr><tr><td style="border-bottom:1px solid #CCC;">&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td align="center" valign="middle"><b style="font-size:18px;">'.$contato_titulo.'</b></td></tr><tr><td>&nbsp;</td></tr><tr><td align="center" valign="middle">'.$contato_subtit.'</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td style="font-size:13px;"><b>Nome:</b> '.$contato_nome.'<br /><b>E-mail:</b> <a href="mailto:'.$contato_email.'" style="color:#394C98;">'.$contato_email.'</a><br /><b>Assunto:</b> '.$contato_assunto.'<br /><br /><b>Mensagem:</b><br />'.$contato_mensagem.'</td></tr><tr><td>&nbsp;</td></tr><tr><td style="border-bottom:2px solid '.$contato_cor_borda.';">&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td><div align="center" style="font-size:12px;color:#000;"><u>'.$contato_txt_rodape.'</u></div></td></tr></table><map name="Map2" id="Map2"><area shape="rect" coords="-1,-3,243,128" href="'.$contato_site.'" target="_blank" /></map>');
	###########################################################################################################
	###########################################################################################################
	require_once('PHPMailer/class.phpmailer.php');
	$mailer = new PHPMailer();
	$mailer->IsSMTP();
	$mailer->SMTPDebug = 1;
	$mailer->Port = 587; //Indica a porta de conexão para a saída de e-mails
	$mailer->Host = 'localhost'; //smtp.dominio.com.br
	$mailer->SMTPAuth = true; //define se haverá ou não autenticação no SMTP
	$mailer->Username = 'contato@sogomatsul.com.br'; //Informe o e-mai o completo
	$mailer->Password = 'contato@001'; //Senha da caixa postal
	$mailer->FromName = 'SOGOMAT-SUL'; //Nome que será exibido para o destinatário
	$mailer->From = 'contato@sogomatsul.com.br'; //Obrigatório ser a mesma caixa postal indicada em "username"
	$mailer->AddAddress('rodrigo@tag3.com.br','Anderson'); //Destinatários
	$mailer->Subject = $contato_assunto;
	$mailer->Body = $mensagemHTML;
	$mailer->IsHTML(true); 
	//$mailer->SMTPSecure = 'ssl'; // SSL REQUERIDO
	if($mailer->Send()): $enviou=1; else: $enviou=0; endif;
	############################################################################################################
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>TESTE TAG3</title>
		</head>
		<body>        
			<? if($enviou): echo 'Enviado com sucesso.'; else: echo 'Erro ao enviar, tente novamente.'; endif; ?>
		</body>
	</html>
	<?
	####################################################################################################################################################################
	####################################################################################################################################################################



	####################################################################################################################################################################
	//FAZER UPLOAD DO ARQUIVO
	####################################################################################################################################################################
	function  getExtension($str){
		$i = strrpos($str,".");
		if (!$i){return "";}
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l); return $ext;
	}
	$path = 'admin/arquivos/files/';
	$arquivo=NULL;
	if($_FILES['arquivo']['name']):
		$tmp_file_name = $_FILES['arquivo']['tmp_name'];
		$ext = getExtension($_FILES['arquivo']['name']);
		$name = time().'.'.$ext;
		copy($tmp_file_name,$path.$name);
		$arquivo=$name;
		$arquivo_nome=$_FILES['arquivo']['name'];
	endif;
	####################################################################################################################################################################
	####################################################################################################################################################################



	####################################################################################################################################################################
	//Como pegar a URL com PHP (fonte: http://www.sistemabasico.com.br/2011/03/16/como-pegar-a-url-com-php/)
	####################################################################################################################################################################
	//Exemplo: http://www.dominio.com/teste/meuscript.php?estado=SC&=cidade=Florianopolis
	//Vamos pegar essa URL e dividir em pedaços:
	//	http - Este é o protocolo
	//	www.dominio.com - Este é hostname
	//	teste - Este é o diretório
	//	meuscript.php - Este é o nome do arquivo que contém o script PHP
	//	estado - Este é o primeiro parâmetro e seu valor é 'SC'
	//	cidade - Este é o segundo parâmetro e seu valor é 'Florianopolis'
	// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
	//Pegando o Protocolo - http
	//O protocolo da URL pode ser lido através da variável $_server['SERVER_PROTOCOL'].
	echo $_SERVER['SERVER_PROTOCOL'];
	//No entanto se você for verificar, verá que não obterá simplesmente http ou https, mas sim uma sequência como esta: HTTP/1.1.
	//Então iremos precisar de alguma forma manipular a string para obter o protocolo limpo, ou seja, http ou https apenas:
	$protocolo = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === false) ? 'http' : 'https';
	echo $protocolo;
	//Pegando o Hostname - www.dominio.com
	//Como próximo passo nós iremos descobrir o hostname. Faremos isto com a variável $_SERVER['HTTP_HOST'] da seguinte e simples forma:
	$host = $_SERVER['HTTP_HOST'];
	echo $host;
	//Pegando o scriptname (diretório/nome do arquivo) - teste/meuscript.php
	//A variável $_SERVER['SCRIPT_NAME'] contém o caminho completo com o nome do atual diretório e arquivo PHP:
	$script = $_SERVER['SCRIPT_NAME'];
	echo $script;
	//Pegando os parâmetros da URL - estado=SC&cidade=Florianopolis
	//A última parte da URL pegaremos com a variável $_SERVER['QUERY_STRING'] e podemos fazer de forma similar ao que já estamos fazendo com as outras partes:
	$parametros = $_SERVER['QUERY_STRING'];
	echo $parametros;
	//Pegando a atual URI (Uniform Resource Identifier) - /teste/meuscript.php?estado=SC&cidade=Florianopolis
	//Se o protocolo e o hostname não são importantes para você e você apenas quer o scriptname (caminho para o script PHP) e os parâmetros, então você pode simplesmente utilizar a variável $_SERVER['REQUEST_URI'] da seguinte forma:
	$uri = $_SERVER['REQUEST_URI'];
	echo $uri;
	//De acordo com tudo que vimos, para pegar a atual URL da página podemos fazer algo como:
	$protocolo    = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === false) ? 'http' : 'https';
	$host         = $_SERVER['HTTP_HOST'];
	$script       = $_SERVER['SCRIPT_NAME'];
	$parametros   = $_SERVER['QUERY_STRING'];
	$UrlAtual     = $protocolo . '://' . $host . $script . '?' . $parametros;
	echo $UrlAtual;
	####################################################################################################################################################################
	####################################################################################################################################################################



	############################################################################################################################################
	//PEGAR A URL COMPLETA DA PÁGINA
	############################################################################################################################################
	$urlSite = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 'https://':'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	############################################################################################################################################
	############################################################################################################################################



	############################################################################################################################################
	//REDIRECIONAMENTO
	############################################################################################################################################
	?><script>window.open('<?=SITE;?>', '_self');</script><?
	die("<script>window.open('".SITE."', '_self');</script>");
	?><html><head><title>NOMEDOSITE</title></head><body><script>window.history.back();</script></body></html><?
	############################################################################################################################################
	############################################################################################################################################



	####################################################################################################################################################################
	//PEGA OS DETALHES DA IMAGEM
	####################################################################################################################################################################
	if(empty($lin['pro_imagem'])){
		$imagem='images/sem-imagem.jpg';
		$TamanhoImagem = getimagesize($imagem);
		$Estensao = substr($imagem,-3);
		$EstPermitidas = array("gif","jpg","JPG","png","tif");
		if(in_array($Estensao,$EstPermitidas)): $WidthImg = $TamanhoImagem[0]; $HeightImg = $TamanhoImagem[1]; endif;
		$imagem=SITE.'images/sem-imagem.jpg';
	}else{
		$imagem = 'admin/arquivos/images/'.trim($lin['pro_imagem']);
		$TamanhoImagem = getimagesize($imagem);
		$Estensao = substr($imagem,-3);
		$EstPermitidas = array("gif","jpg","JPG","png","tif");
		if(in_array($Estensao,$EstPermitidas)){ $WidthImg = $TamanhoImagem[0]; $HeightImg = $TamanhoImagem[1]; }
		$imagem=SITE.'admin/arquivos/images/'.trim($lin['pro_imagem']);
	}
	####################################################################################################################################################################
	####################################################################################################################################################################



	####################################################################################################################################################################
	//metasFacebook
	####################################################################################################################################################################
	$metasFacebook = '<meta property="og:url" content="'.$urlSite.'">
		      		  <meta property="og:title" content="'.$lin['gal_titulo'].'">
		      		  <meta property="og:description" content="'.cutHTML(strip_tags('Aqui vai a descrição da página.'),150,'...').'" />
		      		  <meta property="og:image" content="'.$imagem.'" />
					  <meta property="og:image:width" content="'.$WidthImg.'">
					  <meta property="og:image:height" content="'.$HeightImg.'">';
	####################################################################################################################################################################
	####################################################################################################################################################################



	####################################################################################################################################################################
	// 3 ZEROS DO LADO ESQUERDO
	####################################################################################################################################################################
	$numero = 10;
	str_pad($numero, 3, '0', STR_PAD_LEFT);
	####################################################################################################################################################################
	####################################################################################################################################################################



	####################################################################################################################################################################
	// TRATAR VARIÁVEL ANTES DE SALVAR NO BANCO | SEGURANÇA
	####################################################################################################################################################################
	addslashes($variavelInfectada);
	stripslashes($mostraVariavel);
	mysql_real_escape_string($variavelInfectada);
	####################################################################################################################################################################
	####################################################################################################################################################################



	####################################################################################################################################################################
	// VARIÁVEL COM NOME DINÂMICO
	####################################################################################################################################################################
	$i = 1;
	${"nomeDoCampo$i"} = 'abc';
	echo $nomeDoCampo1;
	####################################################################################################################################################################
	####################################################################################################################################################################



	####################################################################################################################################################################
	// CONFIGURAR A FUNÇÃO DATE | DATA
	####################################################################################################################################################################
	date_default_timezone_set('America/Campo_Grande');
	####################################################################################################################################################################
	####################################################################################################################################################################



	####################################################################################################################################################################
	// FORÇAR UM NÚMERO SER INTEIRO | SEGURANÇA
	####################################################################################################################################################################
	$variavel = 'a50r98ea4';
	echo (int)$variavel;
	####################################################################################################################################################################
	####################################################################################################################################################################



	####################################################################################################################################################################
	// COMPRA COM PAGSEGURO
	####################################################################################################################################################################
	$url = 'https://ws.pagseguro.uol.com.br/v2/checkout';

	$nomeCurso = "Curso técnico em Design de Interiores";
	$valorCurso = "247.50";
	
	$data['email'] = 'edgar@ms.senac.br';
	$data['token'] = '7C3CC51652E945E18156DE7101C0F9B6';
	$data['currency'] = 'BRL';
	$data['itemId1'] = '0001';
	$data['itemDescription1'] = utf8_decode($nomeCurso);
	$data['itemAmount1'] = $valorCurso;
	$data['itemQuantity1'] = '1';
	$data['reference'] = 'landpage';
	$data['redirectURL'] = 'http://www.ms.senac.br/page/retorno.php';
	
	$data = http_build_query($data);
	$curl = curl_init($url);
	
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	$xml= curl_exec($curl);
	curl_close($curl);
	$xml= simplexml_load_string($xml);
	if(count($xml -> error) > 0){
		echo 'mensagem de erro';
	}else{
		$chave_compra = $xml -> code;	
		//DEVOLVE A CHAVE DO PAGSEGURO
		$sql_chave	 ="UPDATE tag_inscricoes SET "; 
		$sql_chave	.="ins_chave='".($chave_compra)."'";
		$sql_chave	.=" WHERE ins_id='".($res)."'";	
		$conn->consulta($sql_chave);
		echo 'deu certo! '.$xml -> code;
	}
	####################################################################################################################################################################
	####################################################################################################################################################################



	####################################################################################################################################################################
	//Formatar moedas ou números decimais com a função number_format() do PHP
	####################################################################################################################################################################
	echo number_format($valor,2,".",",");
	####################################################################################################################################################################
	####################################################################################################################################################################



	####################################################################################################################################################################
	//FUNÇÃO CORTA CARACTERES
	####################################################################################################################################################################
	function cutHTML($text,$length=100,$ending='...',$cutWords=false,$considerHtml=false) {
		if($considerHtml){
			if(strlen(preg_replace('/<.*?>/', '', $text)) <= $length) { // se o texto for mais curto que $length, retornar o texto na totalidade
				return $text;
			}
			preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);// separa todas as tags html em linhas pesquisáveis
			$total_length = strlen($ending);
			$open_tags = array();
			$truncate = '';
			foreach ($lines as $line_matchings) {
				if (!empty($line_matchings[1])) { // se existir uma tag html nesta linha, considerá-la e adicioná-la ao output (sem contar com ela)
					if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) { // se for um "elemento vazio" com ou sem barra de auto-fecho xhtml (ex. <br />)
						// não fazer nada // se a tag for de fecho (ex. </b>)
					}else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
						$pos = array_search($tag_matchings[1], $open_tags);// apagar a tag do array $open_tags
						if($pos !== false) { unset($open_tags[$pos]); }
					}else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {// se a tag é uma tag inicial (ex. <b>)
						array_unshift($open_tags, strtolower($tag_matchings[1]));// adicionar tag ao início do array $open_tags
					}
					$truncate .= $line_matchings[1];// adicionar tag html ao texto $truncate
				}
				$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));// calcular a largura da parte do texto da linha; considerar entidades como um caracter
				if ($total_length+$content_length> $length) {
					$left = $length - $total_length;// o número dos caracteres que faltam
					$entities_length = 0;
					if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {// pesquisar por entidades html
						foreach ($entities[0] as $entity) {// calcular a largura real de todas as entidades no alcance "legal"
							if ($entity[1]+1-$entities_length <= $left) {
								$left--;
								$entities_length += strlen($entity[0]);
							} else {
								break;// não existem mais caracteres
							}
						}
					}
					$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
					break;// chegamos à largura máxima, por isso saímos do loop
				} else {
					$truncate .= $line_matchings[2];
					$total_length += $content_length;
				}
				if($total_length>= $length) {// se chegarmos à largura máxima, saímos do loop
					break;
				}
			}
		} else {
			if (strlen($text) <= $length) {
				return $text;
			} else {
				$truncate = substr($text, 0, $length - strlen($ending));
			}
		}
		if (!$cutWords) {// se as palavras não puderem ser cortadas a meio...
			$spacepos = strrpos($truncate, ' ');// ...procurar a última ocorrência de um espaço...
			if (isset($spacepos)) {
				$truncate = substr($truncate, 0, $spacepos);// ...e cortar o texto nesta posição
			}
		}
		$truncate .= $ending;// adicionar $ending no final do texto	
		if($considerHtml) {
			foreach ($open_tags as $tag) {// fechar todas as tags html não fechadas
				$truncate .= '</' . $tag . '>';
			}
		}
		return $truncate;
	}
	####################################################################################################################################################################
	####################################################################################################################################################################
	

	####################################################################################################################################################################
	//ORDENANDO VETOR E MATRIZ
	####################################################################################################################################################################
	// O array
	$array = array(
		array(
			'id' => 1,
			'nome' => 'aaa',
			'data' => '2015-04-06 00:00:00'
		),
		array(
			'id' => 2,
			'nome' => 'bbb',
			'data' => '2015-04-07 00:00:00'
		),
		array(
			'id' => 3,
			'nome' => 'ccc',
			'data' => '2015-04-05 00:00:00'
		)
	);
	// Compara se $a é maior que $b
	function cmp($a,$b){ return $a['data'] < $b['data']; }
	// Ordena
	usort($array, 'cmp');
	// Mostra os valores
	echo '<pre>';
	print_r( $array );
	echo '</pre>';
	####################################################################################################################################################################
	####################################################################################################################################################################


	####################################################################################################################################################################
	// SALVA INFORMAÇÕES DO POST OU GET NUM TXT | SUBMIT , TEXTO , REQUEST
	####################################################################################################################################################################
	$name = 'retorno_'.date('d').date('m').date('Y').'.txt';
	$text = var_export($_REQUEST, true);
	$file = fopen($name, 'a');
	fwrite($file, $text);
	fclose($file);
	####################################################################################################################################################################
	####################################################################################################################################################################


	####################################################################################################################################################################
	// PEGA O DIA DA SEMANA | FUNÇÃO, DATA, DATE
	####################################################################################################################################################################
	function getSemana($strDate){ $arrDaysOfWeek = array('domingo','segunda-feira','ter&ccedil;a-feira','quarta-feira','quinta-feira','sexta-feira','sabado'); $intDayOfWeek = date('w',strtotime($strDate)); return $arrDaysOfWeek[$intDayOfWeek] ; }
	####################################################################################################################################################################
	####################################################################################################################################################################


	##########################################################################
	// PEGAR ID DA URL DO YOUTUBE
	##########################################################################
	function getIdYoutube($url){
		parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		return $my_array_of_vars['v'];  
	}
	##########################################################################
	##########################################################################


	#################################################################################################################################################
	// MASCARA DE QUALQUER VALOR | MASK | TRATAR | TRATAMENTO | STRING // http://blog.clares.com.br/php-mascara-cnpj-cpf-data-e-qualquer-outra-coisa/
	#################################################################################################################################################
	function mask($val, $mask){
		$maskared = '';
		$k = 0;
		for($i=0;$i<=strlen($mask)-1;$i++){
			if($mask[$i] == '#'){
				if(isset($val[$k])){
					$maskared .= $val[$k++];
				}
			}else{
				if(isset($mask[$i])){
					$maskared .= $mask[$i];
				}
			}
		}
		return $maskared;
	}
	#################################################################################################################################################
	#################################################################################################################################################

	
	#################################################################################################################################################
	// PADRÃO CONTATO | AJAX
	#################################################################################################################################################
	/*
	0: VALIDAÇÃO
	1: ENVIADO
	2: ERRO
	*/

	require_once('../funcoes.php');
	$html = '';

	$campo_nome = $conn->tratar($_POST['campo_nome']);
	$campo_email = $conn->tratar($_POST['campo_email']);
	$campo_assunto = $conn->tratar($_POST['campo_assunto']);
	$campo_mensagem = $conn->tratar($_POST['campo_mensagem']);
	$validacao = '';

	if(empty($campo_nome)){ $validacao.='&campo_nome'; }
	if(empty($campo_email)){ $validacao.='&campo_email'; }
	if(empty($campo_assunto)){ $validacao.='&campo_assunto'; }
	if(empty($campo_mensagem)){ $validacao.='&campo_mensagem'; }

	if(empty($validacao)){

		$sql = "INSERT INTO tag3_textos SET ";
		$sql.= "text_data=NOW()";
		$sql.= ",text_data_publicacao=NOW()";
		$sql.= ",text_menu_id='15'";
		$sql.= ",text_subm_id='0'";
		$sql.= ",text_titulo='".$campo_nome."'";
		$sql.= ",text_resumo=''";
		$sql.= ",text_texto='".$campo_mensagem."'";
		$sql.= ",text_texto2=''";
		$sql.= ",text_texto3=''";
		$sql.= ",text_texto4=''";
		$sql.= ",text_texto5=''";
		$sql.= ",text_texto6=''";
		$sql.= ",text_texto7=''";
		$sql.= ",text_texto8=''";
		$sql.= ",text_texto9=''";
		$sql.= ",text_texto10=''";
		$sql.= ",text_info1='".$campo_email."'";
		$sql.= ",text_info2='".$campo_assunto."'";
		$sql.= ",text_info3=''";
		$sql.= ",text_info4=''";
		$sql.= ",text_info5=''";
		$sql.= ",text_info6=''";
		$sql.= ",text_info7=''";
		$sql.= ",text_info8=''";
		$sql.= ",text_info9=''";
		$sql.= ",text_info10=''";
		$sql.= ",text_link=''";
		$sql.= ",text_data1='0000-00-00'";
		$sql.= ",text_data2='0000-00-00'";
		$sql.= ",text_hora1='00:00:00'";
		$sql.= ",text_hora2='00:00:00'";
		$sql.= ",text_valor='0.00'";
		$sql.= ",text_tags=''";
		$sql.= ",text_usu_id='0'";
		$sql.= ",text_ordem='0'";
		$sql.= ",text_destaque='0'";
		$sql.= ",text_status='1'";
		$cid = $conn->consulta($sql);

		if($cid){

			$html = '1:))ENVIADO COM SUCESSO.';

			####################################################################################################################################################################
			// PADRÃOS DE EMAIL SIMPLES
			####################################################################################################################################################################
			if(PHP_OS == "Linux") $quebra_linha = "\n"; //Se for Linux
			elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows

			$sqlConfig = "SELECT text_titulo FROM tag3_textos WHERE text_menu_id='1' AND text_subm_id='0' LIMIT 1";
			$resConfig = $conn->consulta($sqlConfig);
			$linConfig = $conn->busca($resConfig);

			$contato_sender		= 'contato@thinksd.com.br';//SENDER
			$contato_remetente	= 'contato@thinksd.com.br'; //QUEM ESTÁ ENVIANDO
			$contato_destino 	= $linConfig['text_titulo'];//QUEM VAI RECEBER
			$comcopia          	= '';
			$comcopiaoculta    	= '';

			$contato_site		= 'http://www.thinksd.com.br/';//CAMINHO DO SITE
			$contato_nome_site	= 'THINK';//NOME DO SITE
			$contato_titulo		= 'CONTATO';//TÍTULO DO CONTATO
			$contato_subtit		= 'Segue os detalhes do contato realizado no site.';//SUBTITULO DO CONTATO
			$contato_imagem		= 'http://www.thinksd.com.br/images/topo-email.jpg';//400x100
			$contato_nome		= strip_tags($campo_nome);//NOME DO CONTATO
			$contato_email		= strip_tags($campo_email);//EMAIL DO CONTATO
			$contato_assunto	= strip_tags($campo_assunto);//ASSUNTO DO CONTATO
			$contato_mensagem	= strip_tags(nl2br($campo_mensagem));
			$contato_cor_borda	= '#95D700';//RODAPÉ DO CONTEÚDO
			$contato_txt_rodape	= 'Esta mensagem foi enviada através do formulário de contato.';//INSTRUÇÃO DO E-MAIL

			################################################################################################################################################################################
			//CONTEÚDO DO E-MAIL
			################################################################################################################################################################################
			$mensagemHTML = '<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:18px;color:#000000;"><tr><td align="center" style="padding:5px 0;"><img src="'.$contato_imagem.'" alt="" width="400" height="100" usemap="#Map2" style="display:block" /></td></tr><tr><td style="border-bottom:1px solid #CCC;">&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td align="center" valign="middle"><b style="font-size:18px;">'.$contato_titulo.'</b></td></tr><tr><td>&nbsp;</td></tr><tr><td align="center" valign="middle">'.$contato_subtit.'</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td style="font-size:13px;"><b>Nome:</b> '.$contato_nome.'<br /><b>E-mail:</b> '.$contato_email.'<br /><b>Assunto:</b> '.$contato_assunto.'<br /><br /><b>Mensagem:</b><br />'.str_replace('\n','<br>',$contato_mensagem).'</td></tr><tr><td>&nbsp;</td></tr><tr>';
			$mensagemHTML.= '<td style="border-bottom:2px solid '.$contato_cor_borda.';">&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td><div align="center" style="font-size:12px;color:#000;"><u>'.$contato_txt_rodape.'</u></div></td></tr></table><map name="Map2" id="Map2"><area shape="rect" coords="-1,-3,243,128" href="'.$contato_site.'" target="_blank" /></map>';
			################################################################################################################################################################################

			$headers  = 'MIME-Version: 1.1'.$quebra_linha;
			$headers .= 'Content-type: text/html; charset=iso-8859-1'.$quebra_linha;
			$headers .= 'From: '.trim($contato_nome_site).' <'.trim($contato_remetente).'>'.$quebra_linha;
			$headers .= 'Return-Path: '.$contato_nome_site.' <'.trim($contato_remetente).'>'.$quebra_linha;
			if(strlen($comcopia)>0) $headers .= 'Cc: '.$comcopia.$quebra_linha;
			if(strlen($comcopiaoculta)>0) $headers.='Bcc: '.$comcopiaoculta.$quebra_linha;
			$headers .= 'Reply-To: '.trim($contato_email).$quebra_linha;

			@$enviou=mail($contato_destino,$contato_assunto,$mensagemHTML,$headers,"-r".$contato_sender);
			####################################################################################################################################################################
			//FIM PADRÃO E-MAIL
			####################################################################################################################################################################

		}else{
			$html = '2:))ERRO AO ENVIAR, TENTE NOVAMENTE.';
		}
		
	}else{
		$html = '0:))CAMPOS NÃO PREENCHIDOS OU INVÁLIDOS.:))'.$validacao;
	}

	echo $html;

	#################################################################################################################################################
	#################################################################################################################################################





	#################################################################################################################################################
	//EXPORTAR DADOS DO BANCO PARA CSV
	#################################################################################################################################################
	function exportMysqlToCsv($table,$campos='*',$where='1=1',$filename='exportado.csv'){
		$csv_terminated = "\n";
		$csv_separator = ";";
		$csv_enclosed = '"';
		$csv_escaped = "\\";

		$sql = "SELECT ".$campos." FROM ".$table." WHERE ".$where;
		$res = mysql_query($sql);
		$fields_cnt = mysql_num_fields($res);
		
		$schema_insert = '';
		for ($i = 0; $i < $fields_cnt; $i++){
			$l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed,stripslashes(mysql_field_name($res, $i))) . $csv_enclosed;
			$schema_insert .= $l;
			$schema_insert .= $csv_separator;
		}
		$out = trim(substr($schema_insert, 0, -1));
		$out .= $csv_terminated;

		while ($row = mysql_fetch_array($res)){
			$schema_insert = '';
			for ($j = 0; $j < $fields_cnt; $j++){
				if ($row[$j] == '0' || $row[$j] != ''){
					if ($csv_enclosed == ''){
						$schema_insert .= $row[$j];
					}else{
						$schema_insert .= $csv_enclosed .str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $row[$j]) . $csv_enclosed;
					}
				}else{
					$schema_insert .= '';
				}
				if ($j < $fields_cnt - 1){
					$schema_insert .= $csv_separator;
				}
			} // end for
			$out .= $schema_insert;
			$out .= $csv_terminated;
		} // end while
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Length: " . strlen($out));

		//header("Content-type: text/x-csv");
		//header("Content-type: text/csv");
		header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=$filename");
		echo $out;
		exit;
	}

	$arquivo = "relatorio-".date('d').date('m').date('Y');
	echo exportMysqlToCsv("tag3_textos","text_id as 'cid',text_titulo as 'nome',text_info1 as 'email',text_info2 as 'telefone',text_info3 as 'cidade',text_data_publicacao as 'data'","text_menu_id='9' AND text_subm_id='0'",$arquivo);
	#################################################################################################################################################
	#################################################################################################################################################



	#################################################################################################################################################
	//CONEXÃO COM O BANCO DE DADOS | mysqli
	#################################################################################################################################################
	class Conexao{
	/*
	——————————————
	| Métodos:
	| * desconectar -> encerra a conexão
	| * consulta -> executa query sql
	| * conta -> número de reultados
	| * busca -> array resultado do select
	| * tratar -> trata string
	|——————————————|
	| Utilize à vontade ;- )
	——————————————
	*/	
		/*/
		protected $user 	= ""; // Usuário do banco de dados
		protected $senha 	= ""; // Senha do banco de dados
		protected $bd 		= ""; // Nome do Banco de dados MySQL
		protected $server 	= ""; //host - servidor
		protected $con;
		/*/
		protected $user 	= "tag3"; // Usuário do banco de dados
		protected $senha 	= "aba@tag63#"; // Senha do banco de dados
		protected $bd 		= "boticario"; // Nome do Banco de dados MySQL
		protected $server 	= "localhost"; //host - servidor
		protected $con;
		/**/
		
		//Construtor
		public function __construct() {
			
			$this->con = mysqli_connect($this->server, $this->user, $this->senha) or die("Falha ao conectar com o banco de dados");
			mysqli_select_db($this->con,$this->bd);
			$this->con->set_charset("utf8");
			
			$_SESSION['user']	= $this->user;
			$_SESSION['senha'] 	= $this->senha;
			$_SESSION['server'] = $this->server;
			$_SESSION['bd'] 	= $this->bd;
			
		}
		
		//Encerra a conexão
		public function desconectar() {
			mysql_close($this->con);
		}
		
		//Executa query sql
		public function consulta($sql) {
			$res = mysqli_query($this->con,$sql);
			if(!$res){
				return false;
			}else{
				if(substr($sql,0,6) == "INSERT" && mysqli_insert_id($this->con)){
					return mysqli_insert_id($this->con);
				}else{
					return $res;
				}
			}
		}
		
		//Número de resultados que atendem a uma dada consulta
		public function conta($res) {
			if($res){
				return $res->num_rows;
			}
		}
		
		//Array resultado do select
		public function busca($res) {
			if($res){
				return $res->fetch_array(MYSQLI_BOTH);
			}
		}

		//Trata string
		public function tratar($string) {
			if($string){
				$substituir = array('select','insert','update','delete');
				return $this->con->real_escape_string(str_ireplace($substituir,'',$string));
			}
		}
		
		public function getConn(){
			return $this->con;
		}
		
	} //fim da classe

	require_once('admin/classes/conexao.php');
	$conexao = new Conexao();
	#################################################################################################################################################
	#################################################################################################################################################

	#################################################################################################################################################
	//CONEXÃO COM O BANCO DE DADOS | mysql
	#################################################################################################################################################
	class Conexao{
	/*
	——————————————
	| Métodos:
	| * desconectar -> encerra a conexão
	| * consulta -> executa query sql
	| * conta -> número de reultados
	| * busca -> array resultado do select
	|——————————————|
	| Utilize à vontade ;- )
	——————————————
	*/
		///*
		protected $user = "tag3"; // Usuário do banco de dados
		protected $senha = "aba@tag63#"; // Senha do banco de dados
		protected $bd = "admintag3"; // Nome do Banco de dados MySQL
		protected $server = "localhost"; //host - servidor
		protected $con;
		/*
		protected $user = "sonarenergia1"; // Usuário do banco de dados
		protected $senha = "sonarsite90"; // Senha do banco de dados
		protected $bd = "sonarenergia1"; // Nome do Banco de dados MySQL
		protected $server = "mysql01.sonarenergia1.hospedagemdesites.ws"; //host - servidor
		protected $con;
		//*/
		//Construtor
		public function __construct() {
			$this->con = mysql_connect($this->server, $this->user, $this->senha) or die("Falha ao conectar com o banco de dados");
			mysql_select_db($this->bd, $this->con);
			mysql_set_charset('utf8',$this->con);
		}
		
		//Encerra a conexão
		public function desconectar() {
			mysql_close($this->con);
		}
		
		//Executa query sql
		public function consulta($sql) {
			$res = mysql_query($sql,$this->con);
			if(!$res){
				return false;
			}else{
				if(substr($sql,0,6) == "INSERT" && mysql_insert_id($this->con)){
					return mysql_insert_id($this->con);
				}else{
					return $res;
				}
			}
		}
		
		//Número de resultados que atendem a uma dada consulta
		public function conta($res) {
			if($res){
				return mysql_num_rows($res);
			}
		}
		
		//Array resultado do select
		public function busca($res) {
			if($res){
				return mysql_fetch_array($res);
			}
		}
	} //fim da classe


	require_once('admin/classes/conexao.php');
	$conexao = new Conexao();
	#################################################################################################################################################
	#################################################################################################################################################


	#################################################################################################################################################
	// PEGAR LATITUDE E LONGITUDE DO IFRAME | GOOGLE MAPS | PEGAR DADOS URL
	#################################################################################################################################################
	function pegarDadosIframe($url,$controlador){
	    preg_match( '@src="([^"]+)"@',$url,$match);
	    $src = array_pop($match);
	    $latitude = explode('3d',$src);
	    $longitude = explode('2d',$src);
	    $latitude = explode('!',$latitude[1]);
	    $longitude = explode('!',$longitude[1]);
	    if($controlador=='latitude'){
	        return $latitude[0];
	    }elseif($controlador=='longitude'){
	        return $longitude[0];
	    }else{
	        return 'ERRO!';
	    }    
	}

	$url = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d934.3453701941662!2d-54.62098157083079!3d-20.490577699143262!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9486e5e334ff286b%3A0xc8bc22568666c3ec!2sR.+Ouro+Verde%2C+1314+-+Vila+Marcos+Roberto%2C+Campo+Grande+-+MS%2C+79080-260%2C+Brasil!5e0!3m2!1spt-BR!2sus!4v1480700047501" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>';
	echo pegarDadosIframe($url,'latitude');
	echo '<br>';
	echo pegarDadosIframe($url,'longitude');
	#################################################################################################################################################
	#################################################################################################################################################

?>

<!-- ################################################################### -->
<div onClick="$('.acaoCampoGabarito').css({'display':'block'});">BLOCK</div>
<div onClick="$('.acaoCampoGabarito').css({'display':'none'});">NONE</div>
<!-- ################################################################### -->



<!-- ### REDIRECIONA COM HTML ##################################### -->
<html>
<head>
<meta HTTP-EQUIV="refresh" CONTENT="1;URL=http://www.psu.ms.senai.br/">
<title>Meu Futuro Agora/</title>
</head>
<body>
</body>
</html>
<!-- ### FIM REDIRECIONA COM HTML ##################################### -->





<!-- ### MODELO DE EMAIL ##################################### -->
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:18px;color:#000000;">
<tr><td align="center" style="padding:5px 0;"><img src="images/logo-email.jpg" alt="" width="400" height="100" usemap="#Map2" style="display:block" /></td></tr>
<tr><td style="border-bottom:1px solid #CCC;">&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td align="center" valign="middle"><b style="font-size:18px;">SOLICITAÇÃO</b></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td align="center" valign="middle">Foi emitida uma nova solicitação de compra.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr>
    <td>
        <!--
        <table cellpadding="0" cellspacing="0" width="600">
            <tr>
                <td width="210" align="center" valign="middle" bgcolor="#151515" style="color:#FFF;">NÚMERO DO PEDIDO<br /><b>8653</b></td>
                <td width="10"></td>
                <td width="380" valign="middle" bgcolor="#E9E9D0" style="padding:10px 0;">
                    <table cellpadding="0" cellspacing="0" width="380">
                        <tr>
                            <td width="10"></td>
                            <td width="79"><img src="http://www.belashopcosmeticos.com.br/images/visa.jpg" alt="'.$bandeira.'" width="79" height="49" style="display:block;" /></td>
                            <td width="10"></td>
                            <td width="281">Forma de Pagamento: Visa</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        -->
    </td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
    <td>
        <table cellpadding="0" cellspacing="0" width="600">
            <tr>
                <th style="border:1px solid #EEEEEE;border-right:0;padding:7px;" align="left" width="75%">Pacote</th>
                <th style="border:1px solid #EEEEEE;padding:7px;" align="center" width="25%">Single</th>
            </tr>
            <tr>
                <td style="border:1px solid #EEEEEE;border-top:0;border-right:0;padding:7px;" align="left">Egito e Israel com Dr. Rodrigo Silva </td>
                <td style="border:1px solid #EEEEEE;border-top:0;padding:7px;" align="center">Individual</td>
            </tr>
            <tr>
                <td style="border:1px solid #EEEEEE;border-top:0;border-right:0;padding:7px;" align="left"><b>Valor</b></td>
                <td style="border:1px solid #EEEEEE;border-top:0;padding:7px;" align="center">R$ 1.580,00</td>
            </tr>
        </table>
    </td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr>
    <td style="font-size:13px;">
        <b>DADOS DOS CLIENTE</b><br /><br />
        <b>Nome:</b> Rodrigo Golfeto de Queiroz<br />
        <b>CPF:</b> 050.861.491-00<br />
        <b>E-mail:</b> <a href="mailto:pehdsa@gmail.com" style="color:#394C98;">pehdsa@gmail.com</a><br />
        <b>Tel.</b> 67 9248-6520<br /><br />
        <b>Endereço</b><br />
        Rua Antônio pisiquio 155
    </td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr><td style="border-bottom:2px solid #52A200;">&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><div align="center" style="font-size:12px;color:#000;"><u>Esta mensagem &eacute; autom&aacute;tica, favor n&atilde;o respond&ecirc;-la</u></div></td></tr>
</table><map name="Map2" id="Map2"><area shape="rect" coords="-1,-3,243,128" href="'.SITE.'" target="_blank" /></map>
<!-- ### FIM MODELO DE EMAIL ################################# -->

