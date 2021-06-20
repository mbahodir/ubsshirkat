// Показать полупрозрачный DIV, чтобы затенить страницу
// (форма располагается не внутри него, а рядом, потому что она не должна быть полупрозрачной)
function showCover() {
  let coverDiv = document.createElement('div');
  coverDiv.id = 'cover-div';

  // убираем возможность прокрутки страницы во время показа модального окна с формой
  document.body.style.overflowY = 'hidden';

  document.body.append(coverDiv);
}

function showPayment_sign_up(consumerid_for_payment) {
  showCover();
  let form = document.getElementById('addpay');
  let container = document.getElementById('container_addpay');
  var sign_up = false;
   
  $.ajax ({
      url: 'owner_for_modal.php',
      type: 'POST',
      data: ({consumer_id: consumerid_for_payment}),
      dataType: 'html',
      success: function(data) {$('#owner_for_payment_sign_up').text(data)}
  });

  function complete() {
    $('#payment_save_add').off();
    $('#payment_save_add').prop('disabled', true);
    $('#cover-div').remove();
    document.body.style.overflowY = '';
    container.style.display = 'none';
    document.onkeydown = null;
  }

  $('#inputoper_day_addpay, #inputpayment_sum_addpay').on('change', function () {
    if (
      ($('#inputoper_day_addpay').val() != '') && ($('#inputpayment_sum_addpay').val() != '')
    )
      {$('#payment_save_add').prop('disabled', false)}
  });

  $('#payment_save_add').on('click', function () {
   $.ajax ({
        url: 'payment_add_to_base.php',
        type: 'POST',
        data: ({
            consumer_id: consumerid_for_payment,
            oper_day: $('#inputoper_day_addpay').val(),
            payment_sum: $('#inputpayment_sum_addpay').val(),
            description: $('#description_addpay').val()
        }),
        dataType: 'html',
        success: function(data) {
          if (data == 1) {
            alert($('#inputpayment_sum_addpay').val() + payment_sign_up.msg[i]);
            $('#inputoper_day_addpay').val('');$('#inputpayment_sum_addpay').val('');$('#description_addpay').val('');
            $('#payment_save_add').prop('disabled', false);
            $.ajax ({
                url: 'getpayments.php',
                type: 'POST',
                data: ({ConsumersId: consumerid_for_payment}),
                dataType: 'html',
                success: function(data) {
                    fpayments = payments = JSON.parse(data);
                    viewPayments(payments, false);
                    $.ajax({
                      url: 'consumer_balance_modal.php',
                      type: 'POST',
                      data: ({consumer_id: consumerid_for_payment, shirkatId: shirkat_id}),
                      dataType: 'html',
                      success: function(data) {data = JSON.parse(data);viewConsumer(data, true)}
                    })
                }
            });
          } 
        }
    });
  });

  $('#payment_exit_add').on('click', function() {complete()});

  document.onkeydown = function(e) {
    if (e.key == 'Escape') {
      complete();
    }
  };

  $('#payment_exit_add').keydown(function(e) {
      if (e.key == 'Tab' && !e.shiftKey) {
        $('#inputoper_day_addpay').focus();
      }
  });
  $('#inputoper_day_addpay').keydown(function(e) {
      if (e.key == 'Tab' && e.shiftKey) {
        $('#inputpayment_sum_addpay').focus();
      }
  });

  // $('.container').css('display', 'block');
  container.style.display = 'block';
  $('#inputoper_day_addpay').focus();
}
