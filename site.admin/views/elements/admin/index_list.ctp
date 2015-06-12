<?php
//Faz com que os endereços de página e ordenação gerados pelo paginator incluam as variáveis submetidas na url
$this->Paginator->options(array('url' => $this->passedArgs));

if(!isset($setup['searchField']) || $setup['searchField'])
	$this->set('searchBox', $this->element('admin/form/searchBox'));
?>
<section class="grid_<?php echo (!isset($setup['box_order']) && !isset($setup['box_filter']) ? '12' : '9');?>">
	<div class="block-border"><div class="block-content <?php if(empty($setup['pageDescriptionIndex']))echo 'no-padding';?>">
		<h1><?php echo __((isset($setup['pageTitle']) ? $setup['pageTitle'] : $controller));?></h1>
		<div class="block-controls">
            <?php
            echo $pageLinks = '<ul class="controls-buttons">
            	<li>'.$this->Paginator->counter(array('format' => __('Página %page% de %pages%' , true))).'</li>
				<li class="sep"></li>
				'.$this->Paginator->prev('<span class="picto navigation-left"></span> '.__('Anterior', true), array('tag' => 'li', 'escape' => false,), '<span class="picto navigation-left-disabled"></span> '.__('Anterior', true), array('tag' => 'li', 'escape' => false, 'class'=>'controls-block disabled')).'
				'.$this->Paginator->numbers(array(
					'tag' => 'li', 'before' => null, 'after' => null,
					'modulus' => '6', 'separator' => '', 'first' => null, 'last' => null,
				)).'
				'.$this->Paginator->next(__('Próxima', true).' <span class="picto navigation-right"></span>', array('tag' => 'li', 'escape' => false,), __('Próxima', true).' <span class="picto navigation-right-disabled"></span>', array('tag' => 'li', 'escape' => false, 'class'=>'disabled controls-block')).'
			</ul>';
			?>
		</div>
		<?php
			//Se definiu uma descrição para a página
			if(!empty($setup['pageDescriptionIndex'])):
				echo $this->Html->tag('p', $setup['pageDescriptionIndex']);
				//Fecha o block-content e abre outro sem título
				?>
				</div>
				<div class="block-content no-title no-padding">
				<?php
			endif;
		?>
		<div>
			<ul id="<?php echo $model;?>ListIndex" class="extended-list">
			<?php
			$i = 0;
			foreach ($results as $r):
				$class = null;
				$extended_options = array();
				if ($i++ % 2 == 0)$class = ' class="odd"';
			?>
				<li<?php echo $class;?>>
 					<span>
						<?php 
						foreach($setup['listFields'] AS $field=>$field_setup):
							$value = $this->Element('admin/_field_extract', array('r' => $r, 'field' => $field, 'field_setup' => $field_setup));
							
							//Se o campo está com o índice extended-option...
							if(!empty($field_setup['extended-option'])){
								//Armazena os dados do campo para exibí-lo como item extendido (ficando na direita)
								$extended_options[] = $value;
							}else{
								echo $value;
							}
							
						endforeach;
						?>
					</span>
					<ul class="actions">
						<?php 
						if(!empty($setup['listActions'])){
							foreach($setup['listActions'] AS $label=>$action){
								if(empty($action['url']['params'])){
									$action['url']['params'] = '';
								}else if(is_array($action['url']['params'])){
									foreach($action['url']['params'] AS $key=>$value){
										$action['url']['params'][$key] = current(Set::extract($value, $r));
									}
									$action['url']['params'] = implode('/', $action['url']['params']);
								}else{
									$action['url']['params'] = preg_replace('/\{(.*?)\}/e', 'current(Set::extract("\1", $r))', $action['url']['params']);
								}
								
								if(!empty($action['params']['class'])){
									$action['params']['class'] .= ' with-tip';
								}else{
									$action['params']['class'] = ' with-tip';
								}
								
								if(preg_match('/\.(png|gif|jpe?g)$/', $label)){
									if(empty($action['params']['title']))$action['params']['title'] = ucfirst(basename($label));
									$label = $this->Html->image($label);
									$action['params']['escape'] = false;
								}else if(empty($action['params']['title'])){
									$action['params']['title'] = $label;
								}
								
								echo (empty($acl) || !method_exists($acl, 'check') || $acl->check('controllers/'.(!is_array($action['url']) ? $action['url'] : (isset($action['url']['controller']) ? $action['url']['controller'] : $this->params['controller']).(isset($action['url']['action']) ? '/'.$action['url']['action'] : ''))) ? '<li>'.$this->Html->link($label, (!is_array($action['url']) ? $action['url'] : '/'.(isset($action['url']['controller']) ? $action['url']['controller'] : $this->params['controller']).(isset($action['url']['action']) ? '/'.$action['url']['action'] : '')).'/'.$action['url']['params'].(empty($this->params['named']) ? '' : '/'.preg_replace('/(^|\/)([^=]+)=/', '\1\2:', http_build_query($this->params['named'], '', '/'))) , $action['params']).'</li>' : '');
							}
						
						}
						echo ((!isset($setup['disable']) || !in_array('edit-link', $setup['disable'])) && (empty($acl) || !method_exists($acl, 'check') || $acl->check('controllers/'.$this->name.'/edit')) ? '<li>'.$this->Html->link('<span>' . __('Editar', true) . '</span>', array('action' => 'edit', $r[$model][(empty($setup['edit_id']) ? 'id' : $setup['edit_id'])]) + $this->params['named'],array('escape' => false, 'title' => 'Editar', 'class'=>'picto edit with-tip')).'</li>' : '').
							((!isset($setup['disable']) || !in_array('delete-link', $setup['disable'])) && (empty($acl) || !method_exists($acl, 'check') || $acl->check('controllers/'.$this->name.'/delete')) ? '<li>'.$this->Html->link('<span>' . __('Apagar', true) . '</span>', array('action' => 'delete', $r[$model][(empty($setup['delete_id']) ? 'id' : $setup['delete_id'])]) + $this->params['named'], array('escape' => false, 'title' => 'Apagar', 'class'=>'picto delete with-tip'), sprintf('Você tem certeza que deseja apagar o registro %s (cód. %s)?', (isset($r[$model][$setup['displayField']]) ? $r[$model][$setup['displayField']] : ''), $r[$model][(empty($setup['delete_id']) ? 'id' : $setup['delete_id'])])).'</li>' : '')
						; ?>
					</ul>
					<?php if(!empty($extended_options)): ?>
					<ul class="extended-options">
						<?php 
						echo '<li>'.implode('</li><li>', $extended_options).'</li>';
						?>
					</ul>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
		<!-- Footer block -->
		<div class="no-margin block-footer">
			<div class="float-right">
				<?php echo $pageLinks;?>			 
			</div>
			<?php
				echo __('Limite de itens por página:').' <form class="inline" action="'.$this->Html->url(preg_replace('/\/?limit:[^\/]+/', '', '/'.preg_replace('/^\//','',$this->params['url']['url']))).'" method="get">
					<select name="limit" onchange="
						window.location.href = \''.$this->Html->url(preg_replace('/\/?limit:[^\/]+/', '', '/'.preg_replace('/^\//','',$this->params['url']['url']))).'/limit:\' + $(this).val().replace(/%/g, \'*\');
					">';
				$paginator_params = $this->Paginator->params();
				foreach(array(20,50,100,1000,5000) AS $limit){
					echo '<option value="'.$limit.'" '.($paginator_params['defaults']['limit'] == $limit ? 'selected' : '').'>'.$limit.'</option>';
				}
				echo '</select><noscript><input type="submit" value="OK" /></noscript></form>';
			?>
		</div>
	</div></div>
</section>
<?php if(isset($setup['box_order']) || isset($setup['box_filter'])): ?>
<section class="grid_3">
<?php
	echo $this->Element('admin/_box_order');
	echo $this->Element('admin/_box_filter');
?>
</section>
<?php
endif;
