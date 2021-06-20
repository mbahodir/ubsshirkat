<?php session_start() ?>
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
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="ico/ubs.jpg" type="image/jpeg">
    <script src="js/jquery.min.js"></script>
    <script src="js/langs.js"></script>
    <script>
        var i;
        function setLang(i){
            document.title = lang.title[i];
            $('#labellogin').text(lang.login[i]); $('#inputlogin').attr('placeholder', lang.login[i]);
            $('#labelpsw').text(lang.psw[i]); $('#inputpsw').attr('placeholder', lang.psw[i]);
            // $('#labellang').text(login.labellang[i]);
            $('#button').val(login.button[i]);
            $('#selectlang option').filter(function() {return ($(this).val() == i);}).prop('selected', true);
            $('#a').val(lang.sign_up[i]);
            $('#h2').text(login.h2[i]);
            $('#em').text(login.em[i]);
        }
        function session(){
            // Бу функция саҳифа очилганда сессияга 0 қиймат беради;
            <?php if (!isset($_SESSION['langId'])) 
                      {$_SESSION['langId'] = '0'; ?> i = 0; setLang(i); <?php } 
                      else {?> i = '<?php echo $_SESSION['langId'] ?>'; setLang(i); <?php } ?>
        }
        $(document).ready (function () {
            $('#selectlang').bind('change', function (){
                $.ajax ({
                    url: 'setsessionlang.php',
                    type: 'POST',
                    data: ({langId: $('#selectlang').val()}),
                    dataType: 'html',
                     success: function(data) { i = data; setLang(i); }
                });  
            });    
        })
        // Логин ва паролни база билан текширамиз. Агар мос келса, id_user ни $_SESSION['id_user'] юклаб оламиз 
        $(document).ready (function () {
            $('#button').click('button', function (){
                if ($('#inputlogin').val() && $('#inputpsw').val()){
                $.ajax ({
                        url: 'checklogpsw.php',
                        type: 'POST',
                        data: ({username: $('#inputlogin').val(), password: $('#inputpsw').val()}),
                        dataType: 'html',
                        success: function(data) {
                           if (data == 0) {$(location).attr('href', 'shirkat_sign_up.php')}
                           else if (data == 1) {$(location).attr('href', 'consumer_form.php')} 
                           else if (data == 2) {$(location).attr('href', 'flattype_form.php')} 
                           else if (data == 'loginpswwrong') {alert(login.labelcheckloginpsw[i])}
                        }
                });
                } else alert(login.labelcheckloginpswempty[i]);
            });
        });
    </script>
  </head>
  <body class='form-v4' onload='session()'>
    <div class='page-content'>
      <div class='form-v4-content'>   
        <img src = 'img/ubs2.png'>
        <div class='about-banner'><h2 id='h2'></h2></div>
        <div class='about-banner1'>
          <select id='selectlang' name='lang' onchange='setLang(this.value)'>
                   <option value=0>Ўз</option>
                   <option value=1>O'z</option>
                   <option value=2>Ру</option>
                   <option value=3>En</option>
          </select>
        </div>
        <form class='form-detail' action='#' method='post' id='myform'>
          <!-- <div> -->
          <!-- </div> -->
          <div class='form-group'>

            <div class='form-row'>
              <label id='labellogin' for='username'></label><!-- <span class='required'>*</span>: -->
              <input id='inputlogin' class='input-text' type='text' autocomplete='username' name='username' class='input-text'>
            </div>
          </div><br>
          <div class='form-group'>
            <div class='form-row'>
              <label id='labelpsw' for='password'></label><!-- <span class='required'>*</span>: -->
              <input id='inputpsw' type='password' autocomplete='current-password' name='password' class='input-text'>
            </div>
          </div>
          <div class='form-row-last'>
            <input id='button' type='submit' class='register'>
            <a href='/user_sign_up.php'><input id='a' class='register'></a>
          </div>
        </form>
      </div>
    </div>

  <!---- FOOTER -->
      <footer id='main-footer' class='text-center p-4'>
          <div class='container'>
             <div class='row'>
                <div class='col'>
                   <p>Copyrigth &copy;<span id='year'></span> 2020 PRBAM</p>
                </div>               
             </div>
          </div>
      </footer>
  </body>
</html>