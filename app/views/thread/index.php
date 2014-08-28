

		<!-- <div class="row">
			<h5 class="header left">Threads</h5>
			<h5 class="right">Logged in as : </h5>
		</div> -->
		<div class="row">
			<div class="row panel" style="padding:0px;background:#DDD;">
				<div class="medium-7 small-12 columns hide-for-small-only">
					<small>Title</small>
				</div>
				<div class="medium-2 small-6 columns hide-for-small-only">
					<small>Views/Replies</small>
				</div>
				<div class="medium-2 small-6 columns hide-for-small-only">
					<small>Last Post By</small>
				</div>
				<div class="medium-1 small-12 columns hide-for-small-only">
					<small>Action</small>
				</div>
			</div>
		<?php $num =1; ?>
		<?php foreach ($threads as $v): ?>
			<div class="row panel" style="padding:0px;"  data-equalizer>
				<div class="medium-7 small-12 columns" data-equalizer-watch>
					<a class=" truncate"href="<?php eh(url('thread/view', array('thread_id' => $v->id))) ?>">
						<img class="" style="max-height:20px;" src="/images/ust.png">
						<?php eh($v->title) ?>
						<span class="right alert label round">Hot!</span>
					</a>
				</div>
				<div class="medium-2 small-6 columns" style="background:#CCCCFF;"  data-equalizer-watch>
					<small>Views : 1,034</small><br>
					<small>Comments : 1,031,983</small>
				</div>
				<div class="medium-2 small-6 columns" style="background:#DDDDDD;"  data-equalizer-watch>
					<small><em>Troll User</em></small>
				</div>
				<div class="medium-1 small-12 columns hide-for-small-only"  data-equalizer-watch>
					<a href="<?php eh(url('thread/view', array('thread_id' => $v->id))) ?>">
					Delete
					</a>
				</div>
			</div>
		<?php endforeach ?>
		</div>
	<a class="btn btn-large btn-inverse" href="<?php eh(url('thread/create')) ?>">Create New Thread</a>
