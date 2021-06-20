// Показать полупрозрачный DIV, чтобы затенить страницу
// (форма располагается не внутри него, а рядом, потому что она не должна быть полупрозрачной)
function showCover() {
  let coverDiv = document.createElement('div');
  coverDiv.id = 'cover-div';

  // убираем возможность прокрутки страницы во время показа модального окна с формой
  document.body.style.overflowY = 'hidden';

  document.body.append(coverDiv);
}

function showFlattype_sign_up(id) {
  showCover();
  let form = document.getElementById('addflattype');
  let container = document.getElementById('container_addflattype');
  var sign_up = false;

  function complete() {
    $('#flattype_save_add').off();
    $('#flattype_save_add').prop('disabled', true);
    $('#cover-div').remove();
    document.body.style.overflowY = '';
    container.style.display = 'none';
    document.onkeydown = null;
  }

  $('#inputflattype_addflattype, #inputmonth_debet_sum_addflattype, #inputfield_addflattype').on('change', function () {
    if (
      ($('#inputflattype_addflattype').val() != '') && ($('#inputmonth_debet_sum_addflattype').val() != '') && ($('#inputfield_addflattype').val() != '')
    )
      {$('#flattype_save_add').prop('disabled', false)}
  });

  $('#flattype_save_add').on('click', function () {
   $.ajax ({
        url: 'flattype_add_to_base.php',
        type: 'POST',
        data: ({
            shirkatId: id,
            type: $('#inputflattype_addflattype').val(),
            month_debet_sum: $('#inputmonth_debet_sum_addflattype').val(),
            field: $('#inputfield_addflattype').val(),
            msgerr: lang.msgerr[i]
        }),
        dataType: 'html',
        success: function(data) {
          if (data == 1) {
            alert($('#inputflattype_addflattype').val() + lang.saved[i]);
            $('#inputflattype_addflattype').val('');$('#inputmonth_debet_sum_addflattype').val('');$('#inputfield_addflattype').val('');
            $('#flattype_save_add').prop('disabled', false);
            ReloadFlattype()
          } else {alert(JSON.parse(data))}
        }
    });
  });

  $('#flattype_exit_add').on('click', function() {complete()});

  document.onkeydown = function(e) {
    if (e.key == 'Escape') {
      complete();
    }
  };

  $('#flattype_exit_add').keydown(function(e) {
      if (e.key == 'Tab' && !e.shiftKey) {
        $('#inputflattype_addflattype').focus();
      }
  });
  $('#inputflattypetype_addflattype').keydown(function(e) {
      if (e.key == 'Tab' && e.shiftKey) {
        $('#inputmonth_debet_sum_addflattype').focus();
      }
  });

  // $('.container').css('display', 'block');
  container.style.display = 'block';
  $('#inputflattype_addflattype').focus();
}
