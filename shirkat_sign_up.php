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
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="ico/ubs.jpg" type="image/jpeg">
    <script src="js/jquery.min.js"></script>
    <script src="js/langs.js"></script>
    <script>
      var i = '<?php echo $_SESSION['langId']?>';
      function setLang(){
        document.title = lang.title[i];
        $('#labelRegion').text(shirkat_sign_up.labelRegion[i]);
          $('#selectRegion').attr('placeholder', shirkat_sign_up.labelRegion[i]);
        $('#labelDistrict').text(shirkat_sign_up.labelDistrict[i]);
          $('#selectDistrict').text(shirkat_sign_up.labelDistrict[i]);
        $('#labelMahalla').text(shirkat_sign_up.labelMahalla[i]);
          $('#mahalla').attr('placeholder', shirkat_sign_up.labelMahalla[i]);
        $('#labelName').text(shirkat_sign_up.labelName[i]);
          $('#name').attr('placeholder', shirkat_sign_up.labelName[i]);
        $('#register').val(lang.register[i]);
        $('#h2').text(shirkat_sign_up.h2[i]);
        $('#selectDistrict').append($("<option value='0' selected>" + shirkat_sign_up.labelDistrict[i] + "</option>"));
      }
      $(document).ready (function () {
        $('#selectDistrict').bind('change', function (){$('#labelselectDistrictempty').text('');});
        $('#mahalla').bind('input', function (){$('#labelmahallaempty').text('');});
        $('#name').bind('input', function (){$('#labelnameempty').text('');});
        $('#selectRegion').bind('change', function (){
          $('#labelselectRegionempty').text('');
          $('#selectDistrict').empty();
          $('#selectDistrict').append($("<option value='0' selected>" + shirkat_sign_up.labelDistrict[i] + "</option>"));
          $.ajax ({
            url: 'getdistrict.php',
            type: 'POST',
            data: ({region_id: $('#selectRegion').val()}),
            dataType: 'html',
            success: function(data) { data = JSON.parse(data);
              for (var i in data) 
                {$("select[name='district']").append($("<option value='" + data[i]['id'] + "'>" + data[i]['name'] + "</option>"));}
            }     
          });
        });
        $('#register').bind('click', function (){
          if ($('#selectRegion').val() == '0') {$('#labelselectRegionempty').text(shirkat_sign_up.labelselectRegionempty[i]);
          } else       
          if ($('#selectDistrict').val() == '0') {$('#labelselectDistrictempty').text(shirkat_sign_up.labelselectDistrictempty[i]);
          } else             
          if ($('#mahalla').val() == '') {$('#labelmahallaempty').text(shirkat_sign_up.labelmahallaempty[i]); 
          } else             
          if ($('#name').val() == '') {$('#labelnameempty').text(shirkat_sign_up.labelnameempty[i]); 
          } else {
              $.ajax ({
                url: 'shirkat_add_to_base.php',
                type: 'POST',
                data: ({
                  id_region: $('#selectRegion').val(),
                  id_district: $('#selectDistrict').val(),
                  mahalla: $('#mahalla').val(),
                  name: $('#name').val(),
                  msgerr: lang.msgerr[i],
                  user_id: <?php echo $_SESSION['user_id']; ?>
                }),
                dataType: 'html',
                success: function(data) {$(location).attr('href', 'flattype_sign_up.php?shirkat_id=' + JSON.parse(data))}     
              });
            }
        });
      });
    </script>
  </head>
  <body class='form-v4' onload='setLang()'>
    <?php require_once('connection.php');?>
    <div class='page-content'>
      <div class='form-v4-content'>   
        <form class='form-detail' action='/user_add_to_base.php' method='post' enctype='multipart/form-data'>
          <!-- <img src = 'img/ubs2.png'> -->
          <div class='about-banner'><h2 id='h2'></h2></div>
          <div class='form-group'>
            <div class='form-row form-row-1'>
              <label id='labelRegion' for='region'></label>
              <select id='selectRegion' name='region'>
                <option value='0' selected><script>document.write(shirkat_sign_up.labelRegion[i])</script></option>
                <?php
                    $region_sql = mysqli_query($connection, 'SELECT * FROM regions');
                    while ($r2 = mysqli_fetch_assoc($region_sql)) { echo '<option value=' . $r2['id'] . '>' . $r2['name'] . '</option>'; }
                ?>
              </select>
                <br><br><label id='labelselectRegionempty' class='error'></label>
            </div>
            <div class='form-row form-row-1'>
              <label id='labelDistrict' for='district'></label>
              <select id='selectDistrict' name='district'>
                <option value="0" selected></option>
              </select>
                <br><br><label id='labelselectDistrictempty' class='error'></label>
            </div>
          </div>
          <div class='form-group'>
            <div class='form-row form-row-1'>
              <label id='labelMahalla' for='mahalla'></label>
              <input id='mahalla' type='text' name='mahalla' class='input-text'>
                <br><br><label id='labelmahallaempty' class='error'></label>
            </div>
            <div class='form-row form-row-1'>
              <label id='labelName' for='name'></label>
              <input id='name' type='text' name='name' class='input-text'>
                <br><br><label id='labelnameempty' class='error'></label>
            </div>
          </div>
          <div class='form-row-last'>
            <input id='register' class='register'>
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