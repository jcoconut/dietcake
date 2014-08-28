<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>DietCake <?php eh($title) ?></title>

    <!-- <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <script src="http://code.jquery.com/jquery.js"></script> -->
    <!-- <script src="/bootstrap/js/bootstrap.min.js"></script> -->
    <link href="/foundation/css/foundation.css" rel="stylesheet">
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
        <h3>DietCake :<small> The baking</small></h3>
      </div>

      <form method="post" action="<?php eh(url('')); ?>" class="medium-6 columns small-12" style="margin-bottom:0px;">
        <div class="row">
          <div class="small-5 columns">
            <label>Username
              <input type="text" placeholder="username" style="height:1.31rem;">
            </label>
          </div>
          
          <div class="small-5 columns">
            <label>Password
             <input type="password" placeholder="password" style="height:1.31rem;">
            </label>
          </div>
          <div class="small-2 columns">
            <label>&nbsp;
            <input type="submit" class="secondary tiny button"/>
            </label>
          </div>
        </div>

      </form>

    </div>
    <div data-magellan-expedition="fixed" class="mag">
    <div class="icon-bar five-up" style="padding:0px;margin:0px;">
      <a class="item" href="<?php eh(url('/')); ?>" style="">
        <i class="fi-home"></i>
        <label>Home</label>
      </a>
      <a class="item">
        <i class="fi-bookmark"></i>
        <label>Threads</label>
      </a>
      <a class="item">
        <i class="fi-info"></i>
        <label>Info</label>
      </a>
      <a class="item">
        <i class="fi-mail"></i>
        <label>Mail</label>
      </a>
      <a class="item">
        <i class="fi-like"></i>
        <label>Login</label>
      </a>
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
            <li><a href="">Jollibee</a></li>
            <li><a href="">Kentucky FC</a></li>
            <li><a href="">Chowking</a></li>
          </ul>
        </div>
        <div class="small-4 columns">
          <h3><i class="fi-dislike"></i> Less</h3>
          <p>This is Less</p>
          <p>so now you see less of if, okay? no,just kidding</p>
        </div>
        <div class="small-4 columns">
        z
        </div>
      </div>
    </div>
  </div>
    <script>
    console.log(<?php eh(round(microtime(true) - TIME_START, 3)) ?> + 'sec');
    </script>
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="/foundation/js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
