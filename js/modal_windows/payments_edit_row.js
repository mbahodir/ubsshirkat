// Показать полупрозрачный DIV, чтобы затенить страницу
// (форма располагается не внутри него, а рядом, потому что она не должна быть полупрозрачной)
function showCover() {
  let coverDiv = document.createElement('div');
  coverDiv.id = 'cover-div';

  // убираем возможность прокрутки страницы во время показа модального окна с формой
  document.body.style.overflowY = 'hidden';

  document.body.append(coverDiv);
}

function showEditpay_row(id) {
  showCover();
  let form = document.getElementById('editpay');
  let container = document.getElementById('container_editpay');

  $.ajax ({
      url: 'owner_for_modal.php',
      type: 'POST',
      data: ({consumer_id: consumerid_for_payment}),
      dataType: 'html',
      success: function(data) {$('#owner_editpay').text(data)}
  }); 

  $.ajax ({
      url: 'payments_edit_for_modal.php',
      type: 'POST',
      data: ({payment_id: id}),
      dataType: 'html',
      success: function(data) {data = JSON.parse(data);
        $('#oper_day_editpay').attr('oldval', data['oper_day']);
        $('#debet_sum_editpay').attr('oldval', data['debet_sum']);
        $('#payment_sum_editpay').attr('oldval', data['payment_sum']);
        $('#description_editpay').attr('oldval', data['description']);

        $('#oper_day_editpay').text(data['oper_day']);
        $('#debet_sum_editpay').attr('placeholder', data['debet_sum']);
        $('#payment_sum_editpay').attr('placeholder', data['payment_sum']);
        $('#description_editpay').attr('placeholder', data['description']);
      }
  });

  function complete() {
    $('#payment_save_edit').off();
    $('#payment_save_edit').prop('disabled', true);
    $('#cover-div').remove();
    document.body.style.overflowY = '';
    container.style.display = 'none';
    document.onkeydown = null;
  }

  $('#debet_sum_editpay, #payment_sum_editpay, #description_editpay').on('change', function (){



    switch ($(this).val()) {
      case ''                    : {$(this).css('background-color', 'orange');alert(lang.msgerr[i]);
                                    $('#payment_save_edit').prop('disabled', true);break}
      case $(this).attr('oldval'): {$(this).css('background-color', 'white');
                                    $('#payment_save_edit').prop('disabled', true);break}
      default                    : {$(this).css('background-color', 'white');
                                    $('#payment_save_edit').prop('disabled', false);break}
    }


    // switch ($(this).attr('id')) {
    //   case 'debet_sum_editpay': {if ($('#debet_sum_editpay').val() == '') {alert(lang.msgerr[i]); break}
    //     ($('#debet_sum_editpay').attr('oldval') != $('#debet_sum_editpay').val()) ? $('#payment_save_edit').prop('disabled', false) : '';
    //    break}
    //   case 'payment_sum_editpay': {if ($('#payment_sum_editpay').val() == '') {alert(lang.msgerr[i]); break}
    //     ($('#payment_sum_editpay').attr('oldval') != $('#payment_sum_editpay').val()) ? $('#payment_save_edit').prop('disabled', false) : '';
    //    break}
    //   case 'description_editpay': {
    //     ($('#description_editpay').attr('oldval') != $('#description_editpay').val()) ? $('#payment_save_edit').prop('disabled', false) : '';
    //    break}
    // }
  });

  $('#payment_save_edit').on('click', function (){
      $.ajax ({
          url: 'payment_update_to_base.php',
          type: 'POST',
          data: ({
              payment_id: id,
              debet_sum: $('#debet_sum_editpay').val(),
              payment_sum: $('#payment_sum_editpay').val(),
              description: $('#description_editpay').val(),
          }),
          dataType: 'html',
          success: function(data) {console.log(JSON.parse(data))
            if (data == 1) {
              datapay = {
                payment_id: id,
                debet_sum: $('#debet_sum_editpay').val(), 
                payment_sum: $('#payment_sum_editpay').val(), 
                description: $('#description_editpay').val()
              };
              viewPayments(datapay, true);

              $.ajax({
                url: 'consumer_balance_modal.php',
                type: 'POST',
                data: ({consumer_id: consumerid_for_payment, shirkatId: shirkat_id}),
                dataType: 'html',
                success: function(data) {data = JSON.parse(data); viewConsumer(data, true)}
              });
              alert($('#debet_sum_editpay').val() + lang.msg_changed[i]);
            } 
          }
      })
  });

  $('#payment_exit_edit').on('click', function(){complete()});

  document.onkeydown = function(e) {
    if (e.key == 'Escape') {complete()}
  };

  $('#payment_exit_edit').keydown(function(e) {
      if (e.key == 'Tab' && !e.shiftKey) {
        $('#debet_sum_editpay').focus();
      }
  });

  $('#debet_sum_editpay').keydown(function(e) {
      if (e.key == 'Tab' && e.shiftKey) {
        $('#payment_sum_editpay').focus();
      }
  });

  // $('.container').css('display', 'block');
  container.style.display = 'block';
  $('#debet_sum_editpay').focus();
}