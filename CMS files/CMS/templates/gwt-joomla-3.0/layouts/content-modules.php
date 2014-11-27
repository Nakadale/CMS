<!-- modules -->
<div class="row padding">
	
		<div class="row">
			<div class="large-9 columns">
				<header>
					<?php if ($option == 'com_content' && $view == 'article'): ?>
						<?php if ($article_title): ?>
							<h1 class="entry-title"><?php echo $article_title;  ?></h1>
						<?php endif ?>
					<?php endif ?>
				</header>
			</div>
		</div>


<div id="content-1col">
	<div class="large-12 columns">
		<jdoc:include type="modules" name="panel-top-1col" style="xhtml" />
	</div>
</div>

<div id="content-2col">
	<div class="large-6 medium-6 columns">
		<jdoc:include type="modules" name="panel-top-2col-1" style="xhtml" />
	</div>

	<div class="large-6 medium-6 columns">
		<jdoc:include type="modules" name="panel-top-2col-2" style="xhtml" />
	</div>
</div>

<div id="content-3col">
	<div class="large-4 medium-4 columns">
		<jdoc:include type="modules" name="panel-top-3col-1" style="xhtml" />
	</div>
	
	<div class="large-4 medium-4 columns">
		<jdoc:include type="modules" name="panel-top-3col-2" style="xhtml" />
	</div>
	
	<div class="large-4 medium-4 columns">
		<jdoc:include type="modules" name="panel-top-3col-3" style="xhtml" />
	</div>
</div>

<div id="content-4col">
	<div class="large-3 medium-3 columns">
		<jdoc:include type="modules" name="panel-top-4col-1" style="xhtml" />
	</div>
	
	<div class="large-3 medium-3 columns">
		<jdoc:include type="modules" name="panel-top-4col-2" style="xhtml" />
	</div>
	
	<div class="large-3 medium-3 columns">
		<jdoc:include type="modules" name="panel-top-4col-3" style="xhtml" />
	</div>
	
	<div class="large-3 medium-3 columns">
		<jdoc:include type="modules" name="panel-top-4col-4" style="xhtml" />
	</div>
</div>

</div>
<!-- end modules -->
