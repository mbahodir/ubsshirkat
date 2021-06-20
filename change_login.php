<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Font-->
    <link rel="stylesheet" type="text/css" href="css/opensans-font.css">
    <link rel="stylesheet" type="text/css" href="fonts/line-awesome/css/line-awesome.min.css">
    <!-- Jquery -->
    <link rel="stylesheet" href="css/site-demos.css">
    <!-- Main Style Css -->
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="shortcut icon" href="ico/ubs.jpg" type="image/gif">
    <script src="js/jquery.min.js"></script>
    <script src="js/langs.js"></script>
    <script>
      var i = '<?php echo $_SESSION['langId']?>';
      var user_id = '<?php echo $_SESSION['user_id']?>';
      var checkpsw = 0;
      function setLang(data){
        $.ajax ({
            url: 'user_get_info.php',
            type: 'POST',
            data: ({userId: user_id}),
            dataType: 'html',
            success: function(data) { data = JSON.parse(data);
              $('#inputloginold').attr('placeholder', data[0]['username']);
              $('#inputloginold').val(data[0]['username']);
              $('#inputlogin').val(data[0]['username']);
            }
        });
        document.title = lang.settings[i];
        $('#labellogin').text(lang.login[i]);
        $('#labelloginold').text(login_change.labelloginold[i]);
        $('#labelloginnew').text(login_change.labelloginnew[i]);
        $('#h2').text(login_change.login[i]);
        $('#change').val(lang.change[i]);
        $('#cancel').val(lang.cancel[i]);
      }
      $(document).ready (function () {
        $('#inputlogin').bind('input', function (){
          if ($('#inputlogin').val() != $('#inputloginold').val()) {$('#change').prop('disabled', false)} 
          $.ajax ({
                  url: 'checklogin.php',
                  type: 'POST',
                  data: ({username: $('#inputlogin').val()}),
                  dataType: 'html',
                  success: function(data) {
                      if (data > 0) {$('#labelchecklogin').text(login_change.labelchecklogin[i]);
                      } else $('#labelchecklogin').text('');
                  }
          });
        });
        $('#inputrepsw').bind('input', function (){ 
         if ($('#inputpsw').val() == $('#inputrepsw').val()) {$('#labelcheckrepsw').text(''); 
         } 
         else $('#labelcheckrepsw').text(login_change.labelcheckrepsw[i]);
        });
      });
    </script>
  </head>
  <body class='form-v4' onload='setLang()'>
    <div class='page-content'>
      <div class='form-v4-content'>   
        <form class='form-detail' action='/user_update_to_base.php?change=login' method='post' enctype='multipart/form-data'>
          <!-- <img src = 'img/ubs2.png'> -->
          <div class='about-banner'><h3 id='h2'></h3></div>
          <div class='form-group'>
            <div class='form-row form-row-1'>
              <label id='labelloginold' for='username'></label>
              <input id='inputloginold' type='text' name="username" class='input-text' disabled='disabled'>
            </div>
            <div class='form-row form-row-1'>
              <label id='labelloginnew' for='username'></label>
              <input id='inputlogin' type='text' name="username" class='input-text'>
              <br><label id='labelchecklogin' class='error'></label>
            </div>
          </div>
          <div class='form-group'>
            <div class='form-row form-row-1'>
              <input id='change' type='submit' class='register' disabled='true'>
            </div>
            <div class='form-row form-row-1'>
              <a href='/consumer_form.php'><input id='cancel' class='register'></a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>