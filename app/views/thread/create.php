<h4>Create a thread</h4>

<div class="alert alert-block">

	<?php if ($thread->hasError() || $comment->hasError()): ?>
	
	<div data-alert class="alert-box warning radius" style="padd	ing:1px;background:#EEE;color:#333;">
		<h5 class="alert-heading"><i class="fi-alert cus-yellow-text cus-shadow" style="font-size:2rem;"></i> Oops..</h5>

		<?php if (!empty($thread->validation_errors['title']['length'])): ?>
			<span class="sub-header clearfix">Title must be between
				<?php safe_output($thread->validation['title']['length'][1]) ?> and
				<?php safe_output($thread->validation['title']['length'][2]) ?> characters in length!
			</span>
		<?php endif ?>
		
		<?php if (!empty($comment->validation_errors['body']['required'])): ?>
			<span class="sub-header clearfix">Content cannot be empty! </span>
		<?php endif ?>		
		
	</div>
	<?php endif ?>

</div>






<form class="well row panel cus-gray4 cus-white-text" method="post" action="<?php safe_output(url('')) ?>" style="min-height:480px;">
	<label for="title">Title</label>
	<input type="text" class="small-12 columns" id="title" name="title" value="<?php safe_output(Param::get('title')) ?>">
	<label for="body">Comment</label>
	<textarea name="body" id="body"><?php safe_output(Param::get('body')) ?></textarea>
	<br />
	<input type="hidden" name="page_next" value="create_end">
	<button type="submit" class="button cus-green">Submit</button>
</form>
<br>
<script src="/ck/ckeditor.js"></script>
<script>
// Replace the <textarea id="editor1"> with a CKEditor
// instance, using default configuration.              
CKEDITOR.replace( 'body', {

uiColor: '#5673A0',
codeSnippet_theme : 'monokai_sublime'

});
</script>