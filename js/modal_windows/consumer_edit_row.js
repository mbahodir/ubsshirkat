// Показать полупрозрачный DIV, чтобы затенить страницу
// (форма располагается не внутри него, а рядом, потому что она не должна быть полупрозрачной)
function showCover() {
  let coverDiv = document.createElement('form');
  coverDiv.id = 'cover-div';

  // убираем возможность прокрутки страницы во время показа модального окна с формой
  document.body.style.overflowY = 'hidden';

  document.body.append(coverDiv);
}

function showConsumer_edit_row(id) {
  showCover();
  let form = document.getElementById('editcons');
  let container = document.getElementById('container_editcons');
  var flattype, calcsign, oldcalcsign;
   
  $.ajax ({
      url: 'consumer_edit_for_modal.php',
      type: 'POST',
      data: ({cons_id: id}),
      dataType: 'html',
      success: function(data) {data = JSON.parse(data);
        flattype = data['flattypes'];
        $('#selectflattype_consumer_edit option').remove();
        $('#inputowner_consumer_edit').attr('oldval', data['owner']);
        $('#inputstreet_consumer_edit').attr('oldval', data['street']);
        $('#inputhouse_consumer_edit').attr('oldval', data['house']);
        $('#inputflat_consumer_edit').attr('oldval', data['flat']);
        $('#inputphone_consumer_edit').attr('oldval', data['phone']);
        $('#inputemail_consumer_edit').attr('oldval', data['email']);
        $('#selectflattype_consumer_edit').attr('oldval', data['flat_id']);
        oldcalcsign = data['sign_auto_calc'];
        $('#inputcalc_start_day').attr('oldval', data['calc_start_day']);
        $('#inputowner_consumer_edit').val(data['owner']);
        $('#inputstreet_consumer_edit').val(data['street']);
        $('#inputhouse_consumer_edit').val(data['house']);
        $('#inputflat_consumer_edit').val(data['flat']);
        $('#inputphone_consumer_edit').val(data['phone']);
        $('#inputemail_consumer_edit').val(data['email']);
        $('#selectflattype_consumer_edit option').remove();
        $('#selectflattype_consumer_edit').append('<option value="' + data['flat_id'] + '">' +
                                                  data['type'] + '</option>');
        flatcount = 0;
        for (j in flattype) {flatcount++;
          $('#selectflattype_consumer_edit').append('<option value=' + flatcount + '>' + flattype[j]['type'] + '</option>')}

        switch (data['sign_auto_calc']) {
          case 'Y': {$('#inputsign_auto_calc1').attr('checked', true); break}
          case 'N': {$('#inputsign_auto_calc2').attr('checked', true); break}
        }
        $('#inputcalc_start_day').val(data['calc_start_day']);
      }
  });

  function complete() {
    $('#consumer_save_edit').off();
    $('#consumer_save_edit').prop('disabled', true);
    $('#cover-div').remove();
    document.body.style.overflowY = '';
    container.style.display = 'none';
    document.onkeydown = null;
  }

  $('#inputowner_consumer_edit, #inputstreet_consumer_edit, #inputhouse_consumer_edit, #inputflat_consumer_edit, #inputphone_consumer_edit, #inputemail_consumer_edit, #selectflattype_consumer_edit, #inputsign_auto_calc1, #inputsign_auto_calc2, #inputcalc_start_day').on('change', function (){
    ($('#inputsign_auto_calc1').is(':checked')) ? calcsign = 'Y' : calcsign = 'N';
    switch ($(this).val()) {
      case ''                    : {$(this).css('background-color', 'orange');alert(lang.msgerr[i]);
                                    $('#consumer_save_edit').prop('disabled', true);break}
      case $(this).attr('oldval'): {$(this).css('background-color', 'white');
                                    $('#consumer_save_edit').prop('disabled', true);break}
      default                    : {$(this).css('background-color', 'white');
                                    $('#consumer_save_edit').prop('disabled', false);break}
    }
    (oldcalcsign != calcsign) ? $('#consumer_save_edit').prop('disabled', false) : '';
    oldcalcsign = calcsign;

    $('diveditcons input').each(function (index, element) {
      ($(element).val() == '') ? $('#consumer_save_edit').prop('disabled', true) : '';return $(element).val() !== ''});
  });

  $('#consumer_save_edit').on('click', function (){
    $.ajax ({
      url: 'consumer_update_to_base.php',
      type: 'POST',
      data: ({
        cons_id: id, 
        owner: $('#inputowner_consumer_edit').val(),
        street: $('#inputstreet_consumer_edit').val(),
        house: $('#inputhouse_consumer_edit').val(),
        flat: $('#inputflat_consumer_edit').val(),
        phone: $('#inputphone_consumer_edit').val(),
        email: $('#inputemail_consumer_edit').val(),
        flattype_id: $('#selectflattype_consumer_edit').val(),
        sign_auto_calc: calcsign,
        calc_start_day: $('#inputcalc_start_day').val()
      }),
      dataType: 'html',
      success: function(data) {
        if (data == 1) {
          $.ajax({
            url: 'consumer_balance_modal.php',
            type: 'POST',
            data: ({consumer_id: consumerid_for_payment, shirkatId: shirkat_id}),
            dataType: 'html',
            success: function(data) {data = JSON.parse(data); viewConsumer(data, true)}
          });
        }
          alert($('#inputowner_consumer_edit').val() + ' - ' + lang.msg_changed[i]);
        $('#consumer_save_edit').prop('disabled', true)
      }
    });
  });

  $('#consumer_exit_edit').on('click', function(){complete()});

  document.onkeydown = function(e) {
    if (e.key == 'Escape') {
      $('#consumer_save_edit').prop('disabled', true);complete();
    }
  };

  $('#consumer_exit_edit').keydown(function(e) {
      if (e.key == 'Tab' && !e.shiftKey) {
        $('#inputowner_consumer_edit').focus();
      }
  });
  $('#inputowner_consumer_edit').keydown(function(e) {
      if (e.key == 'Tab' && e.shiftKey) {
        $('#inputstreet_consumer_edit').focus();
      }
  });

  // $('.container').css('display', 'block');
  container.style.display = 'block';
  $('#inputowner_consumer_edit').focus();
}