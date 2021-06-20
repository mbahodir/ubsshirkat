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
      <script src="js/jquery.md5.min.js" type = "text/javascript" charset = "utf-8"></script>
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
                $('#inputpsw').attr('oldval', data[0]['password']);
              }
          });
          document.title = lang.settings[i];
          $('#labelpsw').text(lang.psw[i]);
          $('#labelpswold').text(psw_change.labelpswold[i]);
          $('#labelpswnew').text(psw_change.labelpswnew[i]);
          $('#labelrepswnew').text(psw_change.labelrepswnew[i]);
          $('#h2').text(psw_change.psw[i]);
          $('#change').val(lang.change[i]);
          $('#cancel').val(lang.cancel[i]);
        }
        $(document).ready (function () {
          $('#inputpsw').bind('input', function (){
            if ($.MD5($('#inputpsw').val()) != $('#inputpsw').attr('oldval')) {
              $('#errupdate').text(lang.errupdate[i]);
              $('#inputpswnew').prop('disabled', true);$('#inputrepswnew').prop('disabled', true);
            }
            else {
              $('#errupdate').text('');
              $('#inputpswnew').prop('disabled', false);$('#inputrepswnew').prop('disabled', false);
              $('#inputrepswnew').bind('input', function (){
               if ($('#inputpswnew').val() === $('#inputrepswnew').val()) {
                $('#labelcheckrepsw').text('');$('#change').prop('disabled', false) 
               } 
               else $('#labelcheckrepsw').text(psw_change.labelcheckrepsw[i]);
              });
            }
          });
        });
      </script>
  </head>
  <body class='form-v4' onload='setLang()'>
    <div class='page-content'>
      <div class='form-v4-content'>   
        <form class='form-detail' action='/user_update_to_base.php?change=psw' method='post' enctype='multipart/form-data'>
          <!-- <img src = 'img/ubs2.png'> -->
          <div class='about-banner'><h3 id='h2'></h3></div>
          <div class='form-group'>
          <div class='form-row form-row-1'>
            <label id='labelpswold' for="psw"></label>
            <input id='inputpsw' type='password' name='psw' class='input-text'>
            <label id='errupdate' class='error'></label>
          </div>
          </div>
          <div class='form-group'>
            <div class='form-row form-row-1'>
              <label id='labelpswnew' for="psw"></label>
              <input id='inputpswnew' type='password' name='psw' class='input-text' disabled='true'>
            </div>
            <div class='form-row form-row-1'>
              <label id='labelrepswnew' for='petsw'></label>
              <input id='inputrepswnew' type='password' name='repsw' class='input-text' disabled='true'>
              <label id='labelcheckrepsw' class='error'></label>
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