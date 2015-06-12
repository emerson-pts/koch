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
			<table id="<?php echo $model;?>TableIndex" class="table no-margin no-margin-bottom" cellspacing="0" width="100%">
				<thead>
					<tr><?php 
						//Cabeçalho da tabela
						//Executa looping nos campos a serem listados
						foreach($setup['listFields'] AS $field=>$field_setup): ?>
						<th scope="col" <?php if(is_array($field_setup) && !empty($field_setup['table_head_cell_param']))echo ' '.$field_setup['table_head_cell_param'];?>>
						<?php 
						//Se é para exibir links de ordenação...
						if(!is_array($field_setup) || (is_array($field_setup) && (empty($field_setup['no_sort']) || !empty($field_setup['sort'])))):?>
						<span class="column-sort">
							<a href="<?php echo $this->Html->url(array('sort' => (is_array($field_setup) && !empty($field_setup['sort']) ? $field_setup['sort'] : $field), 'direction' => 'asc'));?>" title="<?php __('Ordem Crescente')?>" class="sort-up <?php if((is_array($field_setup) && !empty($field_setup['sort']) ? $field_setup['sort'] : $field) == $this->Paginator->sortKey() && $this->Paginator->sortDir() == 'asc')echo 'active';?>"></a>
		                    <a href="<?php echo $this->Html->url(array('sort' => (is_array($field_setup) && !empty($field_setup['sort']) ? $field_setup['sort'] : $field), 'direction' => 'desc'));?>" title="<?php __('Ordem decrescente')?>" class="sort-down <?php if((is_array($field_setup) && !empty($field_setup['sort']) ? $field_setup['sort'] : $field) == $this->Paginator->sortKey() && $this->Paginator->sortDir() == 'desc')echo 'active';?>"></a>
		                </span>
						<?php endif; ?>
		                <?php
		                //Define o rótulo do cabeçalho
						if(!is_array($field_setup))://Se o valor não é uma array ...
							echo $field_setup;
						elseif(array_key_exists('label', $field_setup))://Se tem o índice label ...
							echo $field_setup['label'];
						else://Caso contrário usa o índice
							echo $field;
						endif;
						?>
					</th>
					<?php endforeach; ?><th scope="col" class="table-actions"><?php __('Ações');?></th>
					</tr>
				</thead>
				<tbody>
			<?php
			$i = 0;
			foreach ($results as $r):
				$class = null;
				if ($i++ % 2 == 0)$class = ' class="odd"';
			?>
				<tr<?php echo $class;?>>
					<?php 
					foreach($setup['listFields'] AS $field=>$field_setup):
						echo '<td'.(!empty($field_setup['table_body_cell_param']) ? ' '.$field_setup['table_body_cell_param'] : '').'>';
						
						echo $this->Element('admin/_field_extract', array('r' => $r, 'field' => $field, 'field_setup' => $field_setup));

						echo '</td>';
					endforeach;
					?>
						<td class="table-actions">
							<?php 
							echo $this->Element('admin/list_actions', array('r' => $r, 'tag' => '',));
							
							echo ((!isset($setup['disable']) || !in_array('edit-link', $setup['disable']) && (empty($acl) || !method_exists($acl, 'check') || $acl->check('controllers/'.$this->name.'/edit'))) ? $this->Html->link('<span>' . __('Editar', true) . '</span>', array('action' => 'edit', $r[$model][(empty($setup['edit_id']) ? 'id' : $setup['edit_id'])]) + $this->params['named'],array('escape' => false, 'title' => 'Editar', 'class'=>'picto edit with-tip')) : '').
								' '.
								((!isset($setup['disable']) || !in_array('delete-link', $setup['disable']) && (empty($acl) || !method_exists($acl, 'check') || $acl->check('controllers/'.$this->name.'/delete'))) ? $this->Html->link('<span>' . __('Apagar', true) . '</span>', array('action' => 'delete', $r[$model][(empty($setup['delete_id']) ? 'id' : $setup['delete_id'])]) + $this->params['named'], array('escape' => false, 'title' => 'Apagar', 'class'=>'picto delete with-tip')) : '')
							;
							?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
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
