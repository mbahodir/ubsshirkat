// Показать полупрозрачный DIV, чтобы затенить страницу
// (форма располагается не внутри него, а рядом, потому что она не должна быть полупрозрачной)
function showCover() {
  let coverDiv = document.createElement('div');
  coverDiv.id = 'cover-div';

  // убираем возможность прокрутки страницы во время показа модального окна с формой
  document.body.style.overflowY = 'hidden';

  document.body.append(coverDiv);
}

function showConsumer_sign_up(shirkat_id, district_id) {
  showCover();
  let form = document.getElementById('addcons');
  let container = document.getElementById('container_addcons');
  var flattype;
   
  $.ajax ({
      url: 'flattype_for_modal.php?get=shirkat_id',
      type: 'POST',
      data: ({id: shirkat_id}),
      dataType: 'html',
      success: function(data) {flattype = JSON.parse(data);
        $('#selectflattype_addcons option').remove();
        $('#selectflattype_addcons').append('<option value="0" selected></option>');
        for (j in flattype) {
          $('#selectflattype_addcons').append('<option value=' + flattype[j]['id'] + '>' + flattype[j]['type'] + '</option>')}
      }
  });

  function complete() {
    // hideCover();
    $('#register_consumer_sign_up').off();
    $('#register_consumer_sign_up').prop('disabled', true);
    $('#cover-div').remove();
    document.body.style.overflowY = '';
    container.style.display = 'none';
    document.onkeydown = null;
  }

  $('#inputowner_addcons, #inputstreet_addcons, #inputhouse_addcons, #inputflat_addcons, #inputphone_addcons, #selectflattype_addcons').on('change', function (){
    if (
      ($('#inputowner_addcons').val() != '') &&
      ($('#inputstreet_addcons').val() != '') &&
      ($('#inputhouse_addcons').val() != '') &&
      ($('#inputflat_addcons').val() != '') &&
      ($('#inputphone_addcons').val() != '') &&
      ($('#selectflattype_addcons').val() != 0)
    ) {$('#register_consumer_sign_up').prop('disabled', false)}
  });

  $('#register_consumer_sign_up').on('click', function (){
    $(this).off();
    $.ajax ({
        url: 'consumer_add_to_base.php',
        type: 'POST',
        data: ({
            shirkatId: shirkat_id,
            districtId: district_id,
            owner: $('#inputowner_addcons').val(),
            street: $('#inputstreet_addcons').val(),
            house: $('#inputhouse_addcons').val(),
            flat: $('#inputflat_addcons').val(),
            phone: $('#inputphone_addcons').val(),
            email: $('#inputemail_addcons').val(),
            flattype_id: $('#selectflattype_addcons').val()
        }),
        dataType: 'html',
        success: function(data) {
          // switch (data) {
          //   case 0: {alert(lang.msgcode[i]); break;}
          //   case 1: {alert(lang.msgerr[i]); break;}
          //   case 2: {alert($('#inputowner_addcons').val() + '-' + consumer_sign_up.msg[i]);
          //           $('#inputowner_addcons').val('');$('#inputstreet_addcons').val('');
          //           $('#inputhouse_addcons').val('');$('#inputflat_addcons').val('');
          //           $('#inputflat_addcons').val('');$('#inputphone_addcons').val('');
          //           $('#inputemail_addcons').val('');
          //           $('#inputowner_addcons').attr('placeholder', consumer_sign_up.labelowner[i]);
          //           $('#inputstreet_addcons').attr('placeholder', consumer_sign_up.labelstreet[i]);
          //           $('#inputhouse_addcons').attr('placeholder', lang.number[i]);
          //           $('#inputflat_addcons').attr('placeholder', lang.number[i]);
          //           $('#inputphone_addcons').attr('placeholder', '998YYXXXXXXX');
          //           $('#inputemail_addcons').attr('placeholder', 'name@example.com');
          //           $('#selectflattype_addcons option').remove();
          //           $('#selectflattype_addcons').append('<option value="0" selected></option>');count = 0;
          //           for (j in flattype) {count++;
          //             $('#selectflattype_addcons').append('<option value=' + count + '>' + flattype[j]['type'] + '</option>')}
          //           $('#register_consumer_sign_up').prop('disabled', true);
          //           ReloadConsumer();
          //     break;}
          // }
          if (data == 0) {alert(lang.msgcode[i]);showConsumer_sign_up(shirkat_id, district_id);}
          if (data == 1) {alert(lang.msgerr[i]);}
          if (data == 2) {alert($('#inputowner_addcons').val() + '-' + consumer_sign_up.msg[i]);
            $('#inputowner_addcons').val('');$('#inputstreet_addcons').val('');
            $('#inputhouse_addcons').val('');$('#inputflat_addcons').val('');
            $('#inputflat_addcons').val('');$('#inputphone_addcons').val('');
            $('#inputemail_addcons').val('');
            $('#inputowner_addcons').attr('placeholder', consumer_sign_up.labelowner[i]);
            $('#inputstreet_addcons').attr('placeholder', consumer_sign_up.labelstreet[i]);
            $('#inputhouse_addcons').attr('placeholder', lang.number[i]);
            $('#inputflat_addcons').attr('placeholder', lang.number[i]);
            $('#inputphone_addcons').attr('placeholder', '998YYXXXXXXX');
            $('#inputemail_addcons').attr('placeholder', 'name@example.com');
            $('#selectflattype_addcons option').remove();
            $('#selectflattype_addcons').append('<option value="0" selected></option>');
            for (j in flattype) {
              $('#selectflattype_addcons').append('<option value=' + flattype[j]['id'] + '>' + flattype[j]['type'] + '</option>')}
            $('#register_consumer_sign_up').prop('disabled', true);
            ReloadConsumer();showConsumer_sign_up(shirkat_id, district_id)
          }
        }
    });
  });
  $('#consumer_exit_add').on('click', function(){complete()});

  document.onkeydown = function(e) {
    if (e.key == 'Escape') {
      complete();
    }
  };

  $('#consumer_exit_add').keydown(function(e) {
      if (e.key == 'Tab' && !e.shiftKey) {
        $('#inputowner_addcons').focus();
      }
  });
  $('#inputowner_addcons').keydown(function(e) {
      if (e.key == 'Tab' && e.shiftKey) {
        $('#consumer_exit_add').focus();
      }
  });

  // $('.container').css('display', 'block');
  container.style.display = 'block';
  $('#inputowner_addcons').focus();

}
