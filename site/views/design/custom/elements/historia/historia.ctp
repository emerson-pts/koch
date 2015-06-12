<div class="container">

	<div class="row-fluid">

		<div class="span12">
			<?php
				foreach($banners as $key=> $banner):
					echo $this->Image->thumbImage(
						array(
							'src'	=> $banner['Banner']['imagem'],
							'size'	=> 'w1928',
							#'crop'	=> '380x239',
						),
						array("alt" => $banner['Banner']['titulo'], "class" => 'banner')
					);
				endforeach;
			?>
		</div>

	</div>

	<div class="clear"></div><br />

	<div class="row-fluid historia">
		<div class="span12 pull-center">
			<h2>linha do tempo</h2>
		</div>
			<div class="ano" style="text-align:center;"><?php echo  date("Y"); ?></div>
	</div>

	<div class="row-fluid historia">

		<div class="span12 timeline">

			<div id="timeline"></div>

		</div>

	</div>
</div>

<div class="container">
	<div class="row-fluid">
		<div class="span12">
			<hr />
		</div>
	</div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	if (window.innerWidth < 768) {
        changeTimeline('2');
    } else {
    	changeTimeline('1');
    }

});

function changeTimeline (type) {

	$('#timeline').remove();
    $('<div>').attr('id', 'timeline').appendTo($('.span12.timeline'));

    var timeline_data = [];
    var options       = {};    

   	if(type == '1') {
    	var timeline_data = [
	    <?php
	    	foreach ($historias AS $key => $historia):
	    		$descricao = $historia['Historia']['descricao'];
	    		?>
		   		{
		   			<?php
		   			if($historia['Historia']['destaque'] == '1') { ?>
			        	destaque:   '1',
			        <? } else { ?>
			        	destaque:   null,
			        <? } ?>
		   			title:     '',
			        date:     '<?php echo $historia['Historia']['data_original']?>',
			        type:     'blog_post',
			        dateFormat: 'YYYY',
			        width:    '400',
			        content:  '<span class="title"><?php echo $historia['Historia']['titulo']?></span><?php echo preg_replace('/[\r\n]+/', "", $descricao); ?>',
			        image:    'http://kochtavares.com.br/<?php echo $historia['Historia']['image']?>',
			        <?php
			        if(!empty($historia['Historia']['link'])): ?>
			        	readmore: '<?php echo $historia['Historia']['link']?>'
			        <? endif; ?>
			    },
			<? endforeach; ?>
	    ];
        options       = {
            animation:   true,
            lightbox:    true,
            showYear:    true,
            allowDelete: false,
            columnMode:  'dual',
            order:       'desc'
        };
	}

    if(type == '2') {
        var timeline_data = [
	    <?php
	    	foreach ($historias AS $key => $historia):
	    		$descricao = $historia['Historia']['descricao'];
	    		?>
		   		{
		   			<?php
		   			if($historia['Historia']['destaque'] == '1') { ?>
			        	destaque:   '1',
			        <? } else { ?>
			        	destaque:   null,
			        <? } ?>
		   			title:     '',
			        date:     '<?php echo $historia['Historia']['data_original']?>',
			        type:     'blog_post',
			        dateFormat: 'YYYY',
			        width:    '90%',
			        content:  '<span class="title"><?php echo $historia['Historia']['titulo']?></span><?php echo preg_replace('/[\r\n]+/', "", $descricao); ?>',
			        image:    'http://kochtavares.com.br/<?php echo $historia['Historia']['image']?>',
			        <?php
			        if(!empty($historia['Historia']['link'])): ?>
			        	readmore: '<?php echo $historia['Historia']['link']?>'
			        <? endif; ?>
			    },
			<? endforeach; ?>
	    ];
        options       = {
            animation:   true,
            lightbox:    true,
            showYear:    true,
            allowDelete: false,
            columnMode:  'center',
            order:       'desc'
        };
    }

    var timeline = new Timeline($('#timeline'), timeline_data);
    timeline.setOptions(options);
    timeline.display();


}

//Native javascript solution
window.onresize = function(){
    // if (window.innerHeight > 500) {
    //     changeTimeline(parseInt($(this).val(), 10));
    // }

    if (window.innerWidth < 768) {
        changeTimeline('2');
    } else {
    	changeTimeline('1');
    }

}

</script>
