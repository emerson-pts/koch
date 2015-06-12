<br clear="all" />
<div class="wrapper">
	<cake:nocache><?php echo $this->Session->flash('form'); ?></cake:nocache>
	<div class="cont-formulario-monte">
		
		
		<!-- FORMULARIO MONTE ROTEIRO -->
		<?php echo $this->Form->create('MonteRoteiro', array('url' => '/monte-roteiro')); ?>
		<div class="centraliza-1-inputs">
		<!-- NOME -->
		<!--<div  style="width:187px;float:left">-->
		<?php echo $this->Form->input("nome",array(
			"maxlength" => "100",
				'class'=>'input-nome-consulte',
			)); 
		?>
		<!--</div>-->
		<div class="separador-consulte"></div>
		<!-- EMAIL -->
		<!--<div  style="width:187px;float:left">-->
		<?php echo $this->Form->input("email",array(
			"maxlength" => "100",
				'class'=>'input-nome-consulte',
				
			)); 
		?>
		<!--</div>-->
		<div class="separador-consulte"></div>
		<!-- TELEFONE -->
		<?php echo $this->Form->input("telefone",array(
			"maxlength" => "100",
				'class'=>'input-nome-consulte telMask',
				
			)); 
		?>
		<div class="separador-consulte"></div>
		<!-- CELULAR -->
		<?php echo $this->Form->input("celular",array(
			"maxlength" => "100",
				'class'=>'input-nome-consulte telMask',
				
			)); 
		?>
		<br clear="all" />
		</div><!-- centraliza-1-inputs -->
		<div class="preferencias-monte">
			<div class="float-left-monte">Preferências de contato:</div>
			<!-- RADIO PREFERENCIAS EMAIL TELEFONE -->
			<div class="box-radio-monte">
				<?php	$options_radio=array('email'=>'email','telefone'=>'telefone');
						$attributes_radio=array('legend'=>false);
						echo $this->Form->radio('preferência de contato',$options_radio,$attributes_radio);
				 ?>
			 </div><!-- box-radio-monte -->
			 <br clear="all" />
		</div><!-- preferencias-monte -->
		<hr />
		<!-- SELECT ESTADO -->
		<div class="box-cidade-estado-monte">
		<div class="select_consulte_float">
			<div class="cont-select">
				<?php
					$options_estados = array("AC"=>"Acre", "AL"=>"Alagoas", "AM"=>"Amazonas", "AP"=>"Amapá","BA"=>"Bahia","CE"=>"Ceará","DF"=>"Distrito Federal","ES"=>"Espírito Santo","GO"=>"Goiás","MA"=>"Maranhão","MT"=>"Mato Grosso","MS"=>"Mato Grosso do Sul","MG"=>"Minas Gerais","PA"=>"Pará","PB"=>"Paraíba","PR"=>"Paraná","PE"=>"Pernambuco","PI"=>"Piauí","RJ"=>"Rio de Janeiro","RN"=>"Rio Grande do Norte","RO"=>"Rondônia","RS"=>"Rio Grande do Sul","RR"=>"Roraima","SC"=>"Santa Catarina","SE"=>"Sergipe","SP"=>"São Paulo","TO"=>"Tocantins");
					$options_estados_certo = array_flip($options_estados);
					echo $this->Form->input('Estado', array('type' => 'select', 'options' => $options_estados_certo, "class"=>"select small", 'empty' => false));
				?>
			</div><!-- cont-select -->
		</div><!-- select_consulte_float -->
		<div class="separador-consulte"></div>
		<!-- CIDADE -->
		<?php echo $this->Form->input("cidade",array(
			"maxlength" => "100",
				'class'=>'input-cidade-monte',
				
			)); 
		?>
		</div><!-- box-cidade-estado-monte -->
		<br clear="all" />
		<hr />
		<div class="box-3-linha-monte">
		<!-- DATA DA IDA-->
		<?php echo $this->Form->input("data da ida",array(
			"maxlength" => "100",
				'class'=>'input-data-small dateMask',
				
			)); 
		?>
		<?php // echo $this->Html->image("icon-data.jpg", array("alt" => "", "style" => "float:left;margin:30px 5px;"));?>
		<div class="separador-consulte"></div>
		<!-- DATA DA VOLTA-->
		<?php echo $this->Form->input("data da volta",array(
			"maxlength" => "100",
				'class'=>'input-data-small dateMask',
				
			)); 
		?>
		<?php // echo $this->Html->image("icon-data.jpg", array("alt" => "", "style" => "float:left;margin:30px 5px;"));?>
		<div class="separador-consulte"></div>
		<!-- SELECT ADULTOS -->
		<div class="select_consulte_float">
			<div class="cont-select">
				<?php
					$options_pessoas = array_combine(range(0,9), range(0,9)) + array('+9/grupos' => 'grupos');
					echo $this->Form->input('adultos', array('type' => 'select', 'options' => $options_pessoas, "class"=>"select small", 'empty' => false));
				?>
			</div><!-- cont-select -->
			</div><!-- select_consulte_float -->
			<div class="separador-consulte"></div>
			<!-- SELECT CRIANCAS -->
			<div class="select_consulte_float">
				<!--<div class="nome-select-consulte">crianças</div>-->	
				<div class="cont-select">
					<?php
						echo $this->Form->input('crianças', array('type' => 'select', 'options' => $options_pessoas, "class"=>"select small", 'empty' => false));
					?>
				</div><!-- cont-select -->
			</div><!-- select_consulte_float -->
		</div><!-- box-3-linha-monte -->
		<br clear="all" />
		<hr />
		<!-- RADIO PREFERENCIAS EMAIL TELEFONE -->
		<div class="box-radios-monte">
			<div class="box-radios-left">
				opcionais:
				<?php   //	$options_radio=array('aéreo'=>'aéreo','seguro viagem'=>'seguro viagem');
						//$attributes_radio=array('legend'=>false);
						//echo $this->Form->radio('gender',$options_radio,$attributes_radio);
						echo $form->checkbox('opcional Aéreo', array('type' => 'checkbox', 'value' => 'Aéreo')).'Aéreo';
						echo $form->checkbox('opcional Seguro Viagem', array('type' => 'checkbox', 'value' => 'Seguro Viagem')).'Seguro Viagem'; 
				 ?>
			 </div><!-- box-radios-left -->
			 <div class="box-radios-right">
				hotéis:
				<?php	//$options_radio=array('3 estrelas'=>'3 estrelas','4 estrelas'=>'4 estrelas', '5 estrelas'=>'5 estrelas');
						//$attributes_radio=array('legend'=>false);
						//echo $this->Form->radio('hotéis',$options_radio,$attributes_radio);
						echo $form->checkbox('hotel 3 estrelas', array('type' => 'checkbox', 'value' => '3 estrelas')).'3 estrelas';
						echo $form->checkbox('hotel 4 estrelas', array('type' => 'checkbox', 'value' => '4 estrelas')).'4 estrelas';
						echo $form->checkbox('hotel 5 estrelas', array('type' => 'checkbox', 'value' => '5 estrelas')).'5 estrelas';
				 ?>
			 </div><!-- box-radios-right -->
			 <br clear="all" />
		</div><!-- box-radios-monte -->
		<hr />
		<!-- SELECT DESTINOS -->
		<div class="box-select-destino-como">
		<div class="cont-select">
			<?php
				
				$options_destinos = array ("Nacionais" => "Nacionais", "Internacionais" => "Internacionais", "Cruzeiros" => "Cruzeiros");
				echo $this->Form->input('Tipo de Destino', array('type' => 'select', 'options' => $options_destinos, "class"=>"select big_assunto", 'empty' => false));
			?>
		</div><!-- cont-select -->
		<div class="separador-consulte"></div>
		<!-- SELECT COMO CONHECEU A STOCK TRAVEL -->
		<div class="cont-select">
			<?php
				$options_como = array ("Google" => "Google", "Email Marketing" => "Email Marketing", "Redes Socias" => "Redes Socias", "Indicação" => "Indicação", "Outros" => "Outros");
				echo $this->Form->input('como conheceu a stock travel', array('type' => 'select', 'options' => $options_como, "class"=>"select big_assunto", 'empty' => false));
			?>
		</div><!-- cont-select -->
		</div><!-- box-select-destino-como -->
		<br clear="all" />
		<hr />
		<!-- OBSERVAÇÃO -->
		<div class="centraliza-msg-monte">
			<?php echo $this->Form->input("Informações sobre seu roteiro",array(
				"maxlength" => "500",
					'class'=>'input-mensagem-consulte',
					'type' => 'textarea',
					
				)); 
			?>
		</div><!-- centraliza-msg-monte -->
		<br clear="all" />
		<div class="central-btn-monte">
			<?php // echo $form->end('Enviar');
				echo '<div class="separa-btn-consulte"></div>';
				echo $form->submit('enviar-consulte.jpg', array('type'=>'submit', 'class'=>'btn-enviar-consulte'));
				echo '<div class="separa-btn-consulte"></div>';
				//echo $form->button('', array('type'=>'reset', 'class'=>'btn-limpar-consulte'));
			?>
			<br clear="all" />
			</div><!-- central-btn-monte -->
			<?php echo $form->end(); ?>
			<br clear="all" />
			<hr class="hr-fale" />
	</div><!-- cont-formulario-monte -->
	<?php echo $this->Element('news-redes-socias');?>	
</div><!-- wrapper -->