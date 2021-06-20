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
              $('#inputsurename').val(data[0]['surename']);
              $('#inputsurename').attr('oldval', data[0]['surename']);
              $('#inputname').val(data[0]['name']);
              $('#inputname').attr('oldval', data[0]['name']);
              $('#inputmiddlename').val(data[0]['middlename']);
              $('#inputmiddlename').attr('oldval', data[0]['middlename']);
              $('#inputemail').val(data[0]['email']);
              $('#inputemail').attr('oldval', data[0]['email']);
              $('#inputphone').val(data[0]['phone']);
              $('#inputphone').attr('oldval', data[0]['phone']);
            }
          });
          document.title = lang.settings[i];
          $('#labelsurename').text(lang.surename[i]);$('#labelname').text(lang.name[i]);
          $('#labelmiddlename').text(lang.middlename[i]);
          $('#labelemail').text(lang.email[i]);
          $('#labelphone').text(lang.phone[i]);
          $('#h2').text(change_of_personal_data.personal_data[i]);
          $('#change').val(lang.change[i]);
          $('#cancel').val(lang.cancel[i]);
        }
        $(document).ready (function () {
          $('form').bind('input', function (){
            $('form').find('input[type=text], input[type=email], input[type=tel]').each(function(ev) {
              if($(this).val() != $(this).attr('oldval')) {$('#change').prop('disabled', false)}
          });
          });          
          $('#inputlogin').bind('input', function (){
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
           else $('#labelcheckrepsw').text(Change_of_personal_data.labelcheckrepsw[i]);
          });
        });
      </script>
  </head>
  <body class='form-v4' onload='setLang()'>
    <div class='page-content'>
      <div class='form-v4-content'>   
        <form class='form-detail' action='/user_update_to_base.php?change=data' method='post' enctype='multipart/form-data'>
          <!-- <img src = 'img/ubs2.png'> -->
          <div class='about-banner'><h3 id='h2'></h3></div>
          <div class='form-group'>
            <div class='form-row form-row-1'>
              <label id='labelsurename' for='surename'></label>
              <input id='inputsurename' type='text' name='surename' class='input-text'>
            </div>
            <div class='form-row form-row-1'>
              <label id='labelname' for='name'></label>
              <input id='inputname' type='text' name='name' class='input-text'>
            </div>
          </div>
          <div class='form-group'>
            <div class='form-row form-row-1'>
              <label id='labelmiddlename' for='middlename'></label>
              <input id='inputmiddlename' type='text' name='middlename' class='input-text'>
            </div>
          </div>
          <div class='form-group'>
            <div class='form-row form-row-1'>
              <label id='labelphone' for='phone'></label>
              <input id='inputphone' type='tel' name="phone" placeholder='998XXYYYYYYY' pattern='[0-9]{12}' class='input-text'>
            </div>
            <div class='form-row form-row-1'>
              <label id='labelemail' for='email'></label>
              <input id='inputemail' type='email' name="email" placeholder='name@example.com' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$' class='input-text'>
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