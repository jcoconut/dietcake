<h1><?php eh($thread->title) ?></h1>
<?php foreach ($comments as $k => $v): ?>
<div class="comment">
<div class="meta">
<?php eh($k + 1) ?>: <?php eh($v->username) ?> <?php eh($v->created) ?>
</div>
<div>
<?php echo readable_text($v->body) ?>

</div>
</div>
<?php endforeach ?>
<hr>



<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><?php eh($thread->title) ?></h3>
  </div>
  <div class="modal-body">
    <p>This thread has <?php eh(count($comments)); ?> comments!</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal" >Close</a>
  </div>
</div>
<a href="#myModal" role="button" class="btn" data-toggle="modal">Open Information</a>



<form class="well" method="post" action="<?php eh(url('thread/write')) ?>">
	<label>Your name</label>
	<input type="text" class="span2" name="username" value="<?php eh(Param::get('username')) ?>">
	<label>Comment</label>
	<textarea name="body"><?php eh(Param::get('body')) ?></textarea>
	<br />
	<input type="hidden" name="thread_id" value="<?php eh($thread->id) ?>">
	<input type="hidden" name="page_next" value="write_end">
	<button type="submit" class="btn btn-primary">Submit</button>
</form>
