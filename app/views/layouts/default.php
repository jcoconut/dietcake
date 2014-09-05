<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>KIThub</title>

    <!-- <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <script src="http://code.jquery.com/jquery.js"></script> -->
    <!-- <script src="/bootstrap/js/bootstrap.min.js"></script> -->
    <link href="/foundation/css/foundation.css" rel="stylesheet">
    <link href="/custom/custom.css" rel="stylesheet">
    <link href="/foundation/foundation-icons/foundation-icons.css" rel="stylesheet" >
    <style>
      [data-magellan-expedition], [data-magellan-expedition-clone] {
       padding: 0px;
      }
      .icon-bar > *{
        padding:0.25rem;
      }
      .truncate {
  width: 250px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
    </style>
  </head>

  <body>

    <div class="row">
      <div class="medium-6 columns small-12">
        <h3>KIThub <small> Klab Intriguing Threads</small></h3>
      </div>
      
      <?php flash_message('login_failed'); ?>
      
      <?php if(!check_session('logged_in')): ?>
      <form method="post" action="<?php safe_output(url('user/userlogin')); ?>" class="medium-6 columns small-12" style="margin-bottom:0px;">
        <div class="row">
          <div class="small-5 columns" id="username_container">
            <label>Username
              <input type="text" placeholder="username" name="user_username" style="height:1.31rem;" required>
            </label>
          </div>
          
          <div class="small-5 columns" id="password_container">
            <label>Password
             <input type="password" placeholder="password" name="user_password" style="height:1.31rem;">
            </label>
          </div>
          <div class="small-2 columns" id="submit_container">
            <label>&nbsp;
            <input type="submit" value="Log in" class="tiny button" style="height:1.31rem;padding-top:0.3rem;padding-bottom:0.3rem;">
            </label>
          </div>
        </div>


      </form>
      <?php else: ?>
        <div class="medium-6 columns small-12" style="margin-bottom:0px;">
          <div class="row">
            <div class="small-10 columns">
              <h4>Welcome <?php echo get_session('logged_in','user_fname'); ?> ! </h4>
            </div>

            <div class="small-2 columns right">
            <label>&nbsp;
              <a href="<?php safe_output(url('user/logout')); ?>" class="button tiny secondary right">Logout</a>
            </label>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
    <div data-magellan-expedition="fixed" class="mag">
    <div class="icon-bar five-up" style="padding:0px;margin:0px;">
      <a class="item" href="<?php safe_output(url('/')); ?>" style="">
        <i class="fi-home"></i>
        <label>Home</label>
      </a>
      <a class="item">
        <i class="fi-bookmark"></i>
        <label>Nothing here</label>
      </a>
      <a class="item" onclick="alert('Wala pa nga!');">
        <i class="fi-info"></i>
        <label>Info</label>
      </a>
      <a class="item">
        <i class="fi-mail"></i>
        <label>Nothing here</label>
      </a>
      <?php if(check_session('logged_in')): ?>
      <a class="item" href="<?php safe_output(url('settings/userinfo')); ?>">
        <i class="fi-wrench"></i>
        <label>Settings</label>
      </a>
      <?php else: ?>
      <a class="item" href="<?php safe_output(url('user/registeruser')); ?>">
        <i class="fi-like"></i>
        <label>Register</label>
      </a>

      <?php endif; ?>
      
    </div>
  </div>
    <div class="row">

      <?php echo $_content_ ?>

    </div>
    <div class="row panel">
    <div class="small-4 columns">
      <h3>Title</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrum.</p>
    </div>
    <div class="small-8 columns">
      <div class="row">
        <div class="small-4 columns">
          <h3><i class="fi-list"></i> More</h3>
          <ul class="side-nav">
            <li><a href="http://www.jws.com.ph/">Jollibee</a></li>
            <li><a href="http://www.kfc.com.ph/">Kentucky FC</a></li>
            <li><a href="http://www.chowkingdelivery.com./">Chowking</a></li>
          </ul>
        </div>
        <div class="small-4 columns">
          <h3><i class="cus-error fi-dislike"></i> Less</h3>
          <p>This is Less</p>
          <p>so now you see less of if, okay? no,just kidding</p>
        </div>
        <div class="small-4 columns">
          <h3> Sorry na</h3>
          This site is not ready for code review yet so.. quiet!
        </div>
      </div>
    </div>
  </div>
    <script>
    console.log(<?php safe_output(round(microtime(true) - TIME_START, 3)) ?> + 'sec');
    </script>
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="/foundation/js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
    <script>
    function rep(){
      $( "#username_container" ).html( "<p>All new content. <em>You bet!</em></p>" );
      
    }
    // rep();
    </script>
  </body>
</html>
