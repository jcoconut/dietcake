<h4>Create a thread</h4>

<div class="alert alert-block">

	<?php if ($thread->hasError() || $comment->hasError()): ?>
	
	<div data-alert class="alert-box warning radius" style="padd	ing:1px;background:#EEE;color:#333;">
		<h5 class="alert-heading"><i class="fi-alert" style="font-size:2rem;"></i> Oops..</h5>

		<?php if (!empty($thread->validation_errors['thread_title']['length'])): ?>
			<span class="sub-header clearfix">Title must be between
				<?php safe_output($thread->validation['thread_title']['length'][1]) ?> and
				<?php safe_output($thread->validation['thread_title']['length'][2]) ?> characters in length!
			</span>
		<?php endif ?>
		
		<?php if (!empty($comment->validation_errors['body']['required'])): ?>
			<span class="sub-header clearfix">Content cannot be empty! </span>
		<?php endif ?>		
		<a href="#" class="close">&times;</a>
	</div>
	<?php endif ?>

</div>






<form class="well" method="post" action="<?php safe_output(url('')) ?>">
	<label>Title</label>
	<input type="text" class="span2" name="thread_title" value="<?php safe_output(Param::get('thread_title')) ?>">
	<label>Comment</label>
	<textarea name="body" id="thread_body"><?php safe_output(Param::get('body')) ?></textarea>
	<br />
	<input type="hidden" name="page_next" value="create_end">
	<button type="submit" class="btn btn-primary">Submit</button>
</form>
<script src="/ck/ckeditor.js"></script>
<script>
// Replace the <textarea id="editor1"> with a CKEditor
// instance, using default configuration.              
CKEDITOR.replace( 'thread_body', {

uiColor: '#5673A0',
codeSnippet_theme : 'monokai_sublime'

});
</script>