
		<?php if(is_array($threads) && count($threads)>0): ?>

			<div class="row">
				<div class="medium-6 small-12 columns">
					<?php if(check_session('logged_in')): ?>
						<a class="button tiny secondary" href="<?php echo_htmlschars(url('thread/create')) ?>"><i class="fi-plus"></i> Post New Thread</a>
					<?php else: ?>
						<small>Login or Register to Post a Thread</small>
					<?php endif; ?>
				</div>
				<div class="medium-6 small-12 columns text-center">
					<div class="row">
						<div class="small-12 medium-6 columns">
							<?php echo $paginate['on_page']; ?>
						</div>
						<div class="small-12 medium-6 columns">
							<?php echo $paginate['pages']; ?>
						</div>
											
					</div>
					
				</div>
			</div>

			<div class="row">
				<div class="row panel" style="padding:0px;background:#DDD;">
					<div class="medium-8 small-12 columns hide-for-small-only">
						<small>Title</small>
					</div>
					<div class="medium-2 small-6 columns hide-for-small-only">
						<small>Views/Replies</small>
					</div>
					<div class="medium-2 small-6 columns hide-for-small-only">
						<small>Last Post By</small>
					</div>
					
				</div>

			<?php $num =1; ?>
			<?php foreach ($threads as $thread): ?>
				<div class="row panel" style="padding:0px;"  data-equalizer>
					<div class="medium-8 small-12 columns" data-equalizer-watch>
						<i class="left fi-folder" style="max-height:30px;color:#DDA000;">&nbsp;</i>
						<a class=" truncate"href="<?php echo_htmlschars(url('thread/view', array('thread_id' => $thread['thread_id']))) ?>">
							
							<span class="left">
								<?php echo_htmlschars($thread['thread_title']) ?><br>
								<small><em style="color:#888;">started by : <?php echo $thread['user_username']; ?></em></small>

							</span>
							<?php $thread_date = new DateTime($thread['thread_created']); 
							if($thread_date->format('Y-m-d')==date('Y-m-d')): ?>
								<span class="right secondary cus-shadowbox label round">New</span>
							<?php endif; ?>
							<?php if($thread_date->format('Y-m-d')==date('Y-m-d') && $thread['comment_count']>10): ?>
								<span class="right alert cus-shadowbox label round">Hot!</span>
							<?php endif; ?>
							
						</a>
					</div>
					<div class="medium-2 small-6 columns" style="background:#CCCCFF;"  data-equalizer-watch>
						<small>Views : ?</small><br>
						<small>Replies : <?php echo $thread['comment_count']-1; ?></small>
					</div>
					<div class="medium-2 small-6 columns" style="background:#DDDDDD;"  data-equalizer-watch>
						<small><em><?php echo $thread['last_posted']; ?></em></small><br>
						<small>a few moments ago</small>
					</div>
					
				</div>
			<?php endforeach ?>
			</div>
			<div class="row">
				<div class="medium-6 small-12 columns">
					<?php if(check_session('logged_in')): ?>
						<a class="button tiny secondary" href="<?php echo_htmlschars(url('thread/create')) ?>"><i class="fi-plus"></i> Post New Thread</a>
					<?php else: ?>
						<small>Login or Register to Post a Thread</small>
					<?php endif; ?>
				</div>
				<div class="medium-6 small-12 columns text-center">
					<div class="row">
						<div class="small-12 medium-6 columns">
							<?php echo $paginate['on_page']; ?>
						</div>
						<div class="small-12 medium-6 columns">
							<?php echo $paginate['pages']; ?>
						</div>
											
					</div>
					
				</div>
			</div>


		<?php elseif($threads==="not exist"): ?>
		<div class="row">
			<div class="small-12 columns panel text-center" style="min-height:400px;">
				<h3 class="clearfix">Page does not exist!</h3>
				<h1 class="header clearfix">:(</h1>
				<p><a href="<?php echo_htmlschars(url('thread/create')) ?>"><kbd><i class="fi-plus"></i> Add</kbd></a> a thread now!</p>
			</div>
		</div>


		<?php elseif(count($threads)==0): ?>
		<div class="row">
			<div class="small-12 columns panel text-center" style="min-height:400px;">
				<h3 class="clearfix">There are no threads yet!</h3>
				<h1 class="header clearfix">:(</h1>

				<?php if(check_session('logged_in')): ?>
					<p><a href="<?php echo_htmlschars(url('thread/create')) ?>"><kbd><i class="fi-plus"></i> Add</kbd></a> a thread now!</p>
				<?php else: ?>
					<p><a href="<?php echo_htmlschars(url('thread/register')) ?>"><kbd><i class="fi-plus"></i> Register</kbd></a>to add a thread</p>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>