// Показать полупрозрачный DIV, чтобы затенить страницу
// (форма располагается не внутри него, а рядом, потому что она не должна быть полупрозрачной)
function showCover() {
  let coverDiv = document.createElement('div');
  coverDiv.id = 'cover-div';

  // убираем возможность прокрутки страницы во время показа модального окна с формой
  document.body.style.overflowY = 'hidden';

  document.body.append(coverDiv);
}

function showViewpay_row(id) {
  showCover();
  let form = document.getElementById('viewpay');
  let container = document.getElementById('container_viewpay');

  $.ajax ({
      url: 'owner_for_modal.php',
      type: 'POST',
      data: ({consumer_id: consumerid_for_payment}),
      dataType: 'html',
      success: function(data) {$('#owner_viewpay').text(data)}
  }); 

  $.ajax ({
      url: 'payments_view_for_modal.php',
      type: 'POST',
      data: ({cons_id: consumerid_for_payment, payment_id: id}),
      dataType: 'html',
      success: function(data) {data = JSON.parse(data);
        if (data == null) {$('#remove').append('<td style="width: 100%">' + lang.msg_no[i] + '</td>')}
          else { count = 1;
            for (j in data) {
              $('#payment_history').append(
                '<tr><td style="width: 5%">' + count +
                '</td><td style="width: 10%">' + data[j]['oper_day'] +
                '</td><td style="width: 12%; text-align: right">' + data[j]['debet_sum'] +
                '</td><td style="width: 12%; text-align: right">' + data[j]['payment_sum'] +
                '</td><td style="width: 46%">' + data[j]['description'] +
                '</td><td style="width: 15%">' + data[j]['upd_day'] +
                '</td></tr>'
                                              );
              count++
            }
          }
      }
  });

  function complete() {
    $('#remove > tbody > tr').remove();
    $('#remove > td').remove();
    $('#cover-div').remove();
    document.body.style.overflowY = '';
    container.style.display = 'none';
    document.onkeydown = null;
  }

  $('#payments_exit_view').on('click', function(){complete()});

  document.onkeydown = function(e) {
    if (e.key == 'Escape') {
      complete();
    }
  };

  $('#payments_exit_view').keydown(function(e) {
      if (e.key == 'Tab' && !e.shiftKey) {
        $('#payments_exit_view').focus();
      }
  });

  container.style.display = 'block';
}