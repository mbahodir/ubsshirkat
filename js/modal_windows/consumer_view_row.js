// Показать полупрозрачный DIV, чтобы затенить страницу
// (форма располагается не внутри него, а рядом, потому что она не должна быть полупрозрачной)
function showCover() {
  let coverDiv = document.createElement('div');
  coverDiv.id = 'cover-div';

  // убираем возможность прокрутки страницы во время показа модального окна с формой
  document.body.style.overflowY = 'hidden';

  document.body.append(coverDiv);
}

function showConsumer_view_row(id) {
  showCover();
  let form = document.getElementById('viewcons');
  let container = document.getElementById('container_viewcons');
   
  $.ajax ({
      url: 'consumer_view_for_modal.php',
      type: 'POST',
      data: ({cons_id: id}),
      dataType: 'html',
      success: function(data) {data = JSON.parse(data);
        $('#owner_consumer_view').text(data['owner']);
        $('#street_consumer_view').text(data['street']);
        $('#house_consumer_view').text(data['house']);
        $('#flat_consumer_view').text(data['flat']);
        $('#phone_consumer_view').text(data['phone']);
        $('#email_consumer_view').text(data['email']);
        $('#type_consumer_view').text(data['type']);
      }
  });

  function complete() {
    $('#cover-div').remove();
    document.body.style.overflowY = '';
    container.style.display = 'none';
    document.onkeydown = null;
  }

  $('#consumer_exit_view').on('click', function(){complete()});

  document.onkeydown = function(e) {
    if (e.key == 'Escape') {
      complete();
    }
  };

  $('#consumer_exit_view').keydown(function(e) {
      if (e.key == 'Tab' && !e.shiftKey) {
        $('#consumer_exit_view').focus();
      }
  });

  // $('.container').css('display', 'block');
  container.style.display = 'block';
}