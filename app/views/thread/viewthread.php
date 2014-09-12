<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.2/styles/monokai_sublime.min.css">
<script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.2/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
<div class="row">
	<div class="medium-6 small-12 columns">
		<span class=" clearfix"><?php safe_output($view_thread['thread_title']) ?></span>
		<small>by <?php echo($view_thread['user_fname']); ?></small>
		<a href="" style="color:#555555;" title="Delete thread"><i class="fi-trash cus-shadow"></i></a>
		<a href="" style="color:#555555;" title="Edit thread"><i class="fi-page-edit"></i></a>
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
	<?php foreach ($comments as $comment): ?>
	<div class="panel small-12 columns">
		<div class="row">
			<div class="left medium-6 columns">
				<img class="left" src="http://placecage.com/50/50">
				<small class=""><?php safe_output($comment['user_fname']) ?></small><br>
				<small class="">New Member</small><br>

			</div>
			<div class="right medium-6 columns">
			<small class="right"><?php safe_output($comment['comment_created']) ?></small>
			</div>
		</div>
		<hr>
		<div class="row" style="word-wrap:break-word;">
			<p><?php echo ($comment['comment_body']) ?></p>
		</div>
	</div>
	<?php endforeach ?>
</div>

<div class="row">
	
	<div class="right medium-6 small-12 columns text-center">
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

<?php if(is_logged('logged_in')): ?>
<form class="well" method="post" action="<?php safe_output(url('thread/writecomment')) ?>">

	<label>Comment</label>
	<textarea name="body" id="comment_body"><?php safe_output(Param::get('body')) ?></textarea>
	<br />
	<input type="hidden" name="thread_id" value="<?php echo $view_thread['thread_id']; ?>">
	<input type="hidden" name="page_next" value="write_end">
	<button type="submit" class="btn btn-primary">Submit</button>
</form>
<script src="/ck/ckeditor.js"></script>
<script>

// Replace the <textarea id="editor1"> with a CKEditor
// instance, using default configuration.              
CKEDITOR.replace( 'comment_body', {

uiColor: '#5673A0',
codeSnippet_theme : 'monokai_sublime'

});
</script>
<?php else: ?>


<div class="small-12 columns panel">
<p>Please login to leave a comment</p>

</div>
<?php endif; ?>