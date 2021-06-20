// Показать полупрозрачный DIV, чтобы затенить страницу
// (форма располагается не внутри него, а рядом, потому что она не должна быть полупрозрачной)
function showCover() {
  let coverDiv = document.createElement('form');
  coverDiv.id = 'cover-div';

  // убираем возможность прокрутки страницы во время показа модального окна с формой
  document.body.style.overflowY = 'hidden';

  document.body.append(coverDiv);
}

function showFlattype_edit_row(Id) {
  showCover();
  let form = document.getElementById('editflattype');
  let container = document.getElementById('container_editflattype');
  // var shirkatId;
   
  $.ajax ({
      url: 'flattype_for_modal.php?get=id',
      type: 'POST',
      data: ({id: Id}),
      dataType: 'html',
      success: function(data) {data = JSON.parse(data);
        $('#inputflattype_edit').attr('oldval', data[0]['type']);
        $('#inputmonth_debet_sum_edit').attr('oldval', data[0]['month_debet_sum']);
        $('#inputfield_edit').attr('oldval', data[0]['field']);
        $('#inputflattype_edit').attr('placeholder', data[0]['type']);
        $('#inputmonth_debet_sum_edit').attr('placeholder', data[0]['month_debet_sum']);
        $('#inputfield_edit').attr('placeholder', data[0]['field']);
        $('#inputflattype_edit').val(data[0]['type']);
        $('#inputmonth_debet_sum_edit').val(data[0]['month_debet_sum']);
        $('#inputfield_edit').val(data[0]['field']);
      }
  });

  function complete() {
    $('#flattype_save_edit').off();
    $('#flattype_save_edit').prop('disabled', true);
    $('#cover-div').remove();
    document.body.style.overflowY = '';
    container.style.display = 'none';
    document.onkeydown = null;
  }

  $('#inputflattype_edit, #inputmonth_debet_sum_edit, #inputfield_edit').on('change', function (){
    switch ($(this).val()) {
      case ''                    : {$(this).css('background-color', 'orange');alert(lang.msgerr[i]);
                                    $('#flattype_save_edit').prop('disabled', true);break}
      case $(this).attr('oldval'): {$(this).css('background-color', 'white');
                                    $('#flattype_save_edit').prop('disabled', true);break}
      default                    : {$(this).css('background-color', 'white');
                                    $('#flattype_save_edit').prop('disabled', false);break}
    }
  });

  $('#flattype_save_edit').on('click', function (){
       $.ajax ({
        url: 'flattype_update_to_base.php',
        type: 'POST',
        data: ({
            id: Id,
            type: $('#inputflattype_edit').val(),
            month_debet_sum: $('#inputmonth_debet_sum_edit').val(),
            field: $('#inputfield_edit').val(),
            msgerr: lang.msgerr[i]
        }),
        dataType: 'html',
        success: function(data) {
          if (data == 1) {
            alert($('#inputflattype_edit').val() + ' - ' + lang.edited[i]);
            $('#inputflattype_edit').val('');$('#inputmonth_debet_sum_edit').val('');$('#inputfield_edit').val('');
            $('#flattype_save_add').prop('disabled', true);
            ReloadFlattype()
          } else {alert(JSON.parse(data))}
        }
    });
  });

  $('#flattype_exit_edit').on('click', function(){complete()});

  document.onkeydown = function(e) {
    if (e.key == 'Escape') {
      $('#flattype_save_edit').prop('disabled', true);complete();
    }
  };

  $('#flattype_exit_edit').keydown(function(e) {
      if (e.key == 'Tab' && !e.shiftKey) {
        $('#inputflattype_edit').focus();
      }
  });
  $('#inputflattype_edit').keydown(function(e) {
      if (e.key == 'Tab' && e.shiftKey) {
        $('#inputmonth_debet_sum_edit').focus();
      }
  });

  // $('.container').css('display', 'block');
  container.style.display = 'block';
  $('#inputmonth_debet_sum_edit').focus();
}