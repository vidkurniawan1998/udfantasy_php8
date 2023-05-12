<ul class="nav nav-tabs" role="tablist" style="margin-bottom: 0px">
	<?php foreach($language as $r) {?>
		<li class="nav-item">
			<a class="nav-link <?php echo $r->id == $id_language ? ' active':'' ?> language-change" href="#" data-id="<?php echo $r->id ?>">
				<img src="<?php echo base_url($this->main->path_images().$r->thumbnail) ?>" height="20"> <?php echo $r->title ?>
			</a>
		</li>
	<?php } ?>
</ul>
