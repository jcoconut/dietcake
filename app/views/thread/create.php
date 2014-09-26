<h4>Create a thread</h4>

<div class="alert alert-block">

    <?php if ($thread->hasError() || $comment->hasError()): ?>
    
    <div data-alert class="alert-box warning radius" style="padd    ing:1px;background:#EEE;color:#333;">
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
        <?php if (!empty($comment->validation_errors['body']['length'])): ?>
            <span class="sub-header clearfix">Content can only have a maximum of 500 characters! </span>
        <?php endif ?>      
        
    </div>
    <?php endif ?>

</div>

<form class="well row panel cus-gray4 cus-white-text" method="post" action="<?php safe_output(url('')) ?>" style="min-height:480px;">
    <div class="small-centered medium-10 columns small-12">
    <label for="title">Title</label>
    <input type="text" class="" id="title" name="title" value="<?php safe_output(Param::get('title')) ?>">
    </div>
    <div class="small-centered medium-10 columns small-12">
        <div class="row">
            <div class="medium-6 columns">
            <label for="title">For</label>
                <select name="klub_id">
                        <option value="0" selected="selected">All</option>
                    <?php foreach ($klubs as $klub): ?>
                        <option value="<?php echo $klub['klub_id']; ?>"><?php safe_output($klub['klub_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="medium-6 columns">
            <label for="title">Share to:</label>
                <input type="radio" name="privacy" value="0" id="everyone" checked> <label for="everyone"> Everyone </label>
                <input type="radio" name="privacy" value="1" id="members"> <label for="members"> Members </label>
            </div>
        </div>
    </div>
    <div class="small-12 columns">
    <label for="body">Content  <span class="cus-blue-text" id="left">500</span><small> characters left</small></label>
    <textarea maxlength="500" name="body" id="body"><?php safe_output(Param::get('body')) ?></textarea>
    <br />
    <input type="hidden" name="page_next" value="create_end">
    </div>
    <button type="submit" class="button cus-green">Submit</button>
</form>
<br>
<script src="/ck/ckeditor.js"></script>
<script>           
    CKEDITOR.replace( 'body', {

        uiColor: '#5673A0',
        codeSnippet_theme : 'monokai_sublime'

    });
        var editor = CKEDITOR.instances["body"] ;
        editor.on( 'contentDom', function() {
            var editable = editor.editable();
            var length = 500 - body.value.length;
            editable.attachListener( editor.document, 'keyup', function() {
                var str = CKEDITOR.instances.body.getData();
                str = str.length - 7;
                if(str < 0) {
                    str = 0;
                }
                document.getElementById("left").innerHTML = 500 - str;
                
            } );
        } );
</script>