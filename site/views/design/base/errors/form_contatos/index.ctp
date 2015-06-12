 <div id="gt_tituloInternas">
<span class="vermelho f24 sneakers">FALE CONOSCO</span>
</div>
 <div id="gt_internaColunaEsquerda">
<br clear="all" />
<div class="wrap-imprensa">
	<span class="arial f13 cinza3">
	</span>
        <div class="form_imprensa">
		<cake:nocache><?php echo $this->Session->flash('form_msg'); ?></cake:nocache>
		
        <?php
    		//echo $this->Form->create('Imprensa', array('url' => array('controller' => 'imprensas', 'action' => 'index'),'class'=>false,'id'=>false));
				echo $this->Form->create('FormContato', array('url' => (isset($this->params['originalArgs']['params']['url']['url']) ? '/'.$this->params['originalArgs']['params']['url']['url'] : null)));
        
        	echo $this->Form->input("nome",array(
		    	"maxlength" => "100"/*,
				'div'=>'left',*/
			));
			//email
			echo $this->Form->input("email",array(
		    	"maxlength" => "100",
				'div'=>'right',
			));		    
			
        	echo $this->Html->div('clear',false);
        	//tel
        	echo $this->Form->input("telefone",array(
		    	"maxlength" => "20",
				'div'=>'left',
			));
			//
			echo $this->Form->input("mensagem",array(
					"cols"=> "75",
					"rows"=> "7",
					'type' => 'textarea',
					'limit'	=> '255',
					'style' => 'border: 1px solid #D3D3D2;',
			));
	
			echo $form->end('Enviar', array(
			'div' => false
			)); 	
        ?>
		
		 
        </div><?php //.form_imprensa?>
		
		
</div>
<?php echo $this->Html->link($this->Html->image("logo_sro.jpg", array("alt" => "")), "http://www.sro-la.com.br", array('escape' => false));?>
<div class="arial f13 cinza3" style="width:375px; float:right; margin:20px 100px 0 0;">
	SRO Latin America
	<br/>
	R. Joaquim Floriano, 871 Cj 22 Itaim Bibi 
	<br/>
	CEP 04534-013 - São Paulo, SP  
	<br/>
	Tel.(55) 11 3078.5323
	<br/>
	<a  class="arial f13 cinza3" href="mailto:contato@sro-la.com.br">contato@sro-la.com.br</a> 
	-
	<a  class="arial f13 cinza3" href="http://www.sro-la.com.br">www.sro-la.com.br</a>
</div>


</div><?php //.wrap-imprensa ?>

<div id="gt_internaColunaDireita">
    <!-- Calendário -->
        <div id="gt_calendarioBoxInterna" style="margin-top:10px;">
        	<?php echo $this->Element('calendario'); ?>
        </div>
        <!-- fim do calendário -->
        <!-- separador -->
    	<div class="gt_separadores">
    	</div>
    	<!-- fim do separador -->
    	<!-- multimidia -->
    	<div id="gt_galeriaBoxInterna">
			<?php echo $this->Element('galeria'); ?>
    	</div>
    	<!-- fim de multimidia -->	
    </div>















