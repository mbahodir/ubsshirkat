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
        var checkpsw = 0;
        function setLang(data){
          document.title = lang.title[i];
          $('#labelsurename').text(lang.surename[i]);$('#labelname').text(lang.name[i]);$('#labelmiddlename').text(lang.middlename[i]);
          $('#inputsurename').attr('placeholder', lang.surename[i]);$('#inputname').attr('placeholder', lang.name[i]);$('#inputmiddlename').attr('placeholder', lang.middlename[i]);
          $('#labelemail').text(lang.email[i]);
          // $('#labelerremail').text(user_sign_up.labelerremail[i]);
          $('#labelphone').text(lang.phone[i]);
          $('#labellogin').text(lang.login[i]);
          $('#inputlogin').attr('placeholder', lang.login[i]);
          $('#labelpsw').text(lang.psw[i]);
        //  $('#labelerrpsw').text(lang.labelerrpsw[i]);
          $('#inputpsw').attr('placeholder', lang.psw[i]);
          $('#labelrepsw').text(lang.repsw[i]);
          $('#inputrepsw').attr('placeholder', lang.repsw[i]);
          // $('#go').val() = lang.button[i];
          $('#em').text(user_sign_up.em[i]);
          $('#h2').text(lang.sign_up[i]);
          $('#button').val(lang.sign_up[i]);
          $('#a').text(user_sign_up.a[i]);
          // document.getElementById('a').innerText=user_sign_up.a[i];
        }
        $(document).ready (function () {
          $('#inputlogin').bind('input', function (){
            $.ajax ({
                    url: 'checklogin.php',
                    type: 'POST',
                    data: ({username: $('#inputlogin').val()}),
                    dataType: 'html',
                    success: function(data) {
                        if (data > 0) {$('#labelchecklogin').text(user_sign_up.labelchecklogin[i]);
                        } else $('#labelchecklogin').text('');
                    }
                });
            });
          $('#inputrepsw').bind('input', function (){ 
           if ($('#inputpsw').val() == $('#inputrepsw').val()) {$('#labelcheckrepsw').text(''); 
           } 
           else $('#labelcheckrepsw').text(user_sign_up.labelcheckrepsw[i]);
          });
        });
      </script>
  </head>
  <body class='form-v4' onload='setLang()'>
    <div class='page-content'>
      <div class='form-v4-content'>   
        <form class='form-detail' action='/user_add_to_base.php' method='post' enctype='multipart/form-data'>
          <!-- <img src = 'img/ubs2.png'> -->
            <div class='about-banner'><h2 id='h2'></h2></div>
            <div class='form-group'>
            <div class='form-row form-row-1'>
              <label id='labelsurename' for='surename'></label>
              <input id='inputsurename' type='text' name='surename' required pattern='[а-яa-z -]*?\is' class='input-text'>
            </div>
            <div class='form-row form-row-1'>
              <label id='labelname' for='name'></label>
              <input id='inputname' type='text' name='name' required pattern='[а-яa-z -]*?\is' class='input-text'>
            </div>
          </div>
          <div class='form-group'>
            <div class='form-row form-row-1'>
              <label id='labelmiddlename' for='middlename'></label>
              <input id='inputmiddlename' type='text' name='middlename' required pattern='[а-яa-z -]*?\is' class='input-text'>
            </div>
            <div class='form-row form-row-1'>
              <label id='labelemail' for='email'></label>
              <input id='inputemail' type='email' name='email' placeholder='name@example.com' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$' class='input-text'>
            </div>
          </div>
          <div class='form-group'>
            <div class='form-row form-row-1'>
              <label id='labelphone' for='phone'></label>
              <input id='inputphone' type='tel' name='phone' placeholder='998XXYYYYYYY' pattern='[0-9]{12}' required class='input-text'>
            </div>
            <div class='form-row form-row-1'>
              <label id='labellogin' for='username'></label>
              <input id='inputlogin' type='text' name='username' required class='input-text'>
              <br><label id='labelchecklogin' class='error'></label>
            </div>
          </div>
          <div class='form-group'>
            <div class='form-row form-row-1'>
              <label id='labelpsw' for="psw"></label>
              <input id='inputpsw' type='password' name='psw' required class='input-text'>
            </div>
            <div class='form-row form-row-1'>
              <label id='labelrepsw' for='petsw'></label>
              <input id='inputrepsw' type='password' name='repsw' required class='input-text'>
            </div>
          </div>
          <label id='labelcheckrepsw' class='error'></label>
          <div class='form-row form-row-1'>
            <input id='button' type='submit' class='register'>
            <div class= 'ema'>         
              <em id='em'></em><a id='a' href='/index.php'></a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>