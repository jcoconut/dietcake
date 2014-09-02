<h2><?php echo_htmlschars($thread->title) ?></h2>
<p class="alert alert-success">
You successfully created.
</p>
<a href="<?php echo_htmlschars(url('thread/view', array('thread_id' => $thread->id))) ?>">
&larr; Go to thread
</a>
