<div class="container">
	<cake:nocache><?php echo $this->Session->flash('form'); ?></cake:nocache>

	<!-- FORMULARIO MONTE ROTEIRO -->
	<?php echo $this->Form->create('MonteRoteiro', array('name'=>'monteroteiro','url' => (isset($this->params['originalArgs']['params']['url']['url']) ? '/'.$this->params['originalArgs']['params']['url']['url'] : null))); ?>

	<div class="h2">Dados Pessoais</div>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $this->Form->input("nome",array(
				"maxlength" => "100",
			)); ?>
		</div>
		<div class="span6">
			<?php echo $this->Form->input("email",array(
				"maxlength" => "100",
			)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span3">
			<?php echo $this->Form->input("telefone",array(
				"maxlength" => "100",
				'class'=>'telMask',
			)); ?>
		</div>
		<div class="span3">
			<?php echo $this->Form->input("celular",array(
				"maxlength" => "100",
				'class'=>'telMask',
			)); ?>
		</div>
		<div class="span6">
			<label>Preferências de contato:</label>
			<div class="input radio">
				<?php
					$options_radio=array('email'=>'email','telefone'=>'telefone');
					$attributes_radio=array('legend'=>false);
					echo $this->Form->radio('preferência de contato',$options_radio,$attributes_radio);
				 ?>
			 </div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span8">
			<?php echo $this->Form->input("cidade",array(
				"maxlength" => "100",
				'class'=>'input-cidade-monte',
			)); ?>
		</div>
		<div class="span4 estados">
			<?php
				$estados = array(
					"AC"=>"Acre",
					"AL"=>"Alagoas",
					"AP"=>"Amapá",
					"AM"=>"Amazonas",
					"BA"=>"Bahia",
					"CE"=>"Ceará",
					"DF"=>"Distrito Federal",
					"ES"=>"Espírito Santo",
					"GO"=>"Goiás",
					"MA"=>"Maranhão",
					"MT"=>"Mato Grosso",
					"MS"=>"Mato Grosso do Sul",
					"MG"=>"Minas Gerais",
					"PA"=>"Pará",
					"PB"=>"Paraíba",
					"PR"=>"Paraná",
					"PE"=>"Pernambuco",
					"PI"=>"Piauí",
					"RJ"=>"Rio de Janeiro",
					"RN"=>"Rio Grande do Norte",
					"RS"=>"Rio Grande do Sul",
					"RO"=>"Rondônia",
					"RR"=>"Roraima",
					"SP"=>"São Paulo",
					"SC"=>"Santa Catarina",
					"SE"=>"Sergipe",
					"TO"=>"Tocantins",
				);
				echo $this->Form->input('estado', array('class' => 'selectpicker', 'type' => 'select', 'options' => $estados, 'empty' => 'Selecione'));
			?>
		</div>
	</div>
	<div class="h2">Dados da Viagem</div>
	<div class="row-fluid">
		<div class="span3">
			<?php echo $this->Form->input("data de ida",array(
				"maxlength" => "100",
				'class'=>'dateMask',
				
			)); ?>
		</div>
		<div class="span3">
			<?php echo $this->Form->input("data de volta",array(
				"maxlength" => "100",
				'class'=>'dateMask',
				
			)); ?>
		</div>
		<div class="span3">
			<?php
				$options_pessoas = array_combine(range(0,9), range(0,9)) + array('+9/grupos' => 'grupos');
				echo $this->Form->input('nº de adultos', array('class' => 'selectpicker', 'type' => 'select', 'options' => $options_pessoas, 'empty' => false));
			?>
		</div>
		<div class="span3">
			<?php
				echo $this->Form->input('crianças', array('class' => 'selectpicker', 'type' => 'select', 'options' => $options_pessoas, 'empty' => false));
			?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php
				echo $this->Form->input('Opcionais', array(
					'type' => 'select',
					'multiple' => 'checkbox',
					'options' => array(
						'Aéreo' => 'Aéreo',
						'Seguro Viagem' => 'Seguro Viagem'
					)
				));
//				echo $this->Form->checkbox('opcional Aéreo', array('type' => 'checkbox', 'value' => 'Aéreo')).'Aéreo';
//				echo $this->Form->checkbox('opcional Seguro Viagem', array('type' => 'checkbox', 'value' => 'Seguro Viagem')).'Seguro Viagem'; 
			 ?>
		</div>
		<div class="span6">
			<?php
				echo $this->Form->input('Hotéis', array(
					'type' => 'select',
					'multiple' => 'checkbox',
					'options' => array(
						'3 estrelas' => '3 estrelas',
						'4 estrelas' => '4 estrelas',
						'5 estrelas' => '5 estrelas',
					)
				));
			?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6 right">
			<?php
				echo $this->Form->input('destinos', array('class'=>'selectpicker span12 right', 'type' => 'select', 'options' => $destinos, 'default' => $destino_select['Destino']['id'],'escape' => false));
			?>
		</div>
		<div class="span6 response">
			<?php
				echo $this->Form->input('roteiros', array('class'=>'selectpicker span12', 'type' => 'select', 'options' => $roteiros, 'empty' => 'Selecione'));
			?>
		</div>
		<div class="span6 return" style="display:none;">
			<label>roteiros</label>
			<select class="selectpicker span12">
				<option>Aguarde...</option>
			</select>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<?php echo $this->Form->input("Informações sobre seu roteiro",array(
				"maxlength" => "500",
				'class'=>'input-mensagem-consulte',
				'type' => 'textarea',
			)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12 text-align-center">
			<?php echo $this->Form->submit('enviar',array(
				'class' => 'ff-lobster',
			));
			?>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<?php
echo $this->Html->script(
	array(
		'bootstrap-select'
	)
);
echo $this->Html->css(
	array(
		'bootstrap-select'
	)
);
?>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('.selectpicker').selectpicker();

    <?php if($destino_select['Destino']['id']) { ?>
    	 jQuery.ajax({
                type:'POST',
                async: true,
                cache: false,
                url: '<?php echo Router::Url(array('controller' => 'monte_roteiros', 'admin' => FALSE, 'action' => 'ajax'), TRUE); ?>',
                success: function(response) {
                	jQuery('.return').hide();
                    jQuery('.response').html(response);
                    jQuery('.response').show();
                    jQuery('.selectpicker').selectpicker('refresh');
                },
                data: "data="+<?php echo $destino_select['Destino']['id']; ?>+"&roteiro="+"<?php echo $roteiro_select; ?>"
            });
    <? } ?>

    jQuery('body').delegate('#MonteRoteiroDestinos', 'change',
        function(){
        	jQuery('.response').hide();
        	jQuery('.return').show();
            jQuery.ajax({
                type:'POST',
                async: true,
                cache: false,
                url: '<?php echo Router::Url(array('controller' => 'monte_roteiros', 'admin' => FALSE, 'action' => 'ajax'), TRUE); ?>',
                success: function(response) {
                	jQuery('.return').hide();
                    jQuery('.response').html(response);
                    jQuery('.response').show();
                    jQuery('.selectpicker').selectpicker('refresh');
                },
                data: "data="+$(this).val()
            });
            return false;
        }
    );
});
</script>