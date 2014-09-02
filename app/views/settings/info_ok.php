<div style="min-height:480px;">
  <div data-alert class="panel cus-green cus-shadowbox text-center radius small-12 columns">
    <p style="color:white;">Changes has been saved!<br>
    you will be redirected back to home page after <span id="time">5</span> seconds..<br>
    <a class="tiny secondary button" href="<?php echo url('/settings/info'); ?>">Change again</a></p>
    <?php header( "refresh:5;url=/" ); ?>
   
  </div>
</div>
<script language="javascript">
var max_time = 5;
var cinterval;
 
function countdown_timer(){
  // decrease timer
  max_time--;
  document.getElementById('time').innerHTML = max_time;
  if(max_time == 0){
    clearInterval(cinterval);
  }
}
// 1,000 means 1 second.
cinterval = setInterval('countdown_timer()', 1000);
</script>