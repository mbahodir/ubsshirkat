<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/consumer_form.css">

        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/style_for_modals.css">
        <link rel="shortcut icon" href="ico/ubs.jpg" type="image/jpeg">
        <script src="js/jquery.js"></script>
        <script src="js/moment.js"></script>
        <script src="js/jsrender.js"></script>
        <script src="js/modal_windows/consumer_sign_up.js"></script>
        <script src="js/modal_windows/consumer_view_row.js"></script>
        <script src="js/modal_windows/consumer_edit_row.js"></script>
        <script src="js/modal_windows/payment_sign_up.js"></script>
        <script src="js/modal_windows/payments_view_row.js"></script>
        <script src="js/modal_windows/payments_edit_row.js"></script>
        <!-- <script src="js/modal.js"></script> -->
        <script src="js/langs.js"></script>
        <script id="rowTemplate" type="text/x-jsrender">
            <tr onclick='trclick(this)' id={{>id}} consumersId={{>id}}>
                <td class='tar' style='text-align: right; width: 5%'>{{>tar}}</td>
                <td class='code' id='code{{>id}}' style='text-align: right; width: 6%'>{{>code}}</td>
                <td class='owner' id='owner{{>id}}' style='width: 23%'>{{>owner}}</td>
                <td class='street' id='street{{>id}}' style='width: 15%'>{{>street}}</td>
                <td class='house' id='house{{>id}}' style='text-align: center; width: 6%'>{{>house}}</td>
                <td class='flat' id='flat{{>id}}' style='text-align: center; width: 6%'>{{>flat}}</td>
                <td class='flattype' id='flattype{{>id}}' style='text-align: center; width: 7%'>{{>flattype}}</td>
                <td class='phone' id='phone{{>id}}' style='text-align: center; width: 7%'>{{>phone}}</td>
                <td class='month_debet_sum' id='month_debet_sum{{>id}}' style='text-align: right; width: 7%'>{{>month_debet_sum}}</td>
                <td class='balance' id='balance{{>id}}' style='text-align: right; width: 8%'>{{>balance}}</td>
                <td class='actions' style='text-align : center; width: 10%;'>
                    <a href = '#' onclick = 'showConsumer_view_row({{>id}})'><img src = 'ico/view.ico' title = '{{>title1}}'></a>
                    <a href = '#' onclick = 'showConsumer_edit_row({{>id}})'><img src = 'ico/edit.ico' title = '{{>title2}}'></a>
                    <a href = 'delete_row.php?id={{>id}}&field=owner&table=consumers&deleted={{>deleted}}' onclick="return confirm('{{>confirm}}?')"><img src = 'ico/delete.ico' title = '{{>title3}}'></a>
                </td>
            </tr>
        </script>
        <script id="rowTemplate1" type="text/x-jsrender">
            <tr id={{>payment_id}}>
                <td class='tar1' style='text-align: right; width: 9%'>{{>tar1}}</td>
                <td class='oper_day' style='text-align: center'>{{>oper_day}}</td>
                <td id='paytd{{>payment_id}}' class='payment_sum' style='text-align: right'>{{>payment_sum}}</td>
                <td id='debettd{{>payment_id}}' class='debet_sum' style='text-align: right'>{{>debet_sum}}</td>
                <td id='desctd{{>payment_id}}' class='description' style='width: 30%'>{{>description}}</td>
                <td class='actions' style='text-align: center'>
                    <a href = '#' onclick = 'showViewpay_row({{>payment_id}})'><img src = 'ico/view.ico' title = '{{>title1}}'></a>
                    <a href = '#' onclick = 'showEditpay_row({{>payment_id}})'><img src = 'ico/edit.ico' title = '{{>title2}}'></a>
                    <a href = 'delete_row.php?id={{>payment_id}}&field=payment_sum&table=payments&deleted={{>deleted}}' onclick="return confirm('{{>confirm}}?')"><img src = 'ico/delete.ico' title = '{{>title3}}'></a>
                </td>
            </tr>
        </script>
        <script type="text/javascript">
            var cursor, consumers, fconsumers, payments, fpayments, consumerid_for_payment, balance;
            var i = '<?php echo $_SESSION['langId']?>';
            var shirkat_id = '<?php echo $_SESSION['shirkat_id']?>';
            var district_id = '<?php echo $_SESSION['district_id']?>';
            var modal = false;
            function setLang(){
//consumer_form            
                document.title = lang.title[i];
                $('#pha').text(lang.pha[i]); $('#list_flats').text(lang.list_flats[i]);$('#arrears').text(lang.arrears[i]);
                $('#li1').text(lang.region[i]);$('#li2').text(lang.city[i]);$('#li3').text(lang.mahalla[i]);
                $('#th1').text(lang.code[i]);$('#th2').text(lang.owner[i]);$('#th3').text(lang.address[i]);
                $('#th4').text(lang.house[i]);$('#th5').text(lang.flat[i]);$('#th6').text(lang.flattype[i]);
                $('#th7').text(lang.phone[i]);$('#th8').text(lang.month_debet_sum[i]);$('#th9').text(lang.actions[i]);
                $('#th10').text(lang.date[i]);$('#th11').text(lang.debet_sum[i]);$('#th12').text(lang.paid[i]);
                $('#th13').text(lang.balance[i]);$('#th14').text(lang.description[i]);$('#th15').text(lang.actions[i]);
                $('#accrual').text(lang.accrual[i]);
//settings_menu
                $('#settings').text(lang.settings[i]);
                $('#change_of_personal_data').text(change_of_personal_data.personal_data[i]);
                $('#flattype').text(lang.flattype[i]);
                $('#login').text(login_change.login[i]);
                $('#psw').text(psw_change.psw[i]);                
//consumer_sign_up
                $('#labelowner_addcons').text(lang.owner[i]);
                $('#labelstreet_addcons').text(lang.street[i]);
                $('#labelhouse_addcons').text(lang.house[i]);
                $('#labelflat_addcons').text(lang.flat[i]);
                $('#labelphone_addcons').text(lang.phone[i]);
                $('#labelemail_addcons').text('E-mail');
                $('#labelselectflattype_addcons').text(lang.flattype[i]);
                $('#inputowner_addcons').attr('placeholder', consumer_sign_up.labelowner[i]);
                $('#inputstreet_addcons').attr('placeholder', consumer_sign_up.labelstreet[i]);
                $('#inputhouse_addcons').attr('placeholder', lang.number[i]);
                $('#inputflat_addcons').attr('placeholder', lang.number[i]);
                $('#inputphone_addcons').attr('placeholder', '998YYXXXXXXX');
                $('#inputemail_addcons').attr('placeholder', 'name@example.com');
                $('#selectflattype_addcons').attr('placeholder', lang.flattype[i]);
                $('#register_consumer_sign_up').text(lang.register[i]);$('#register_consumer_sign_up').prop('disabled', true);
                $('#consumer_exit_add').text(lang.exit[i]);
                $('#h4_consumer_sign_up').text(consumer_sign_up.h4[i]);
//consumer_view_row
                $('#labelowner_consumer_view').text(lang.owner[i]);
                $('#labelstreet_consumer_view').text(lang.street[i]);
                $('#labelhouse_consumer_view').text(lang.house[i]);
                $('#labelflat_consumer_view').text(lang.flat[i]);
                $('#labelphone_consumer_view').text(lang.phone[i]);
                $('#labelemail_consumer_view').text(lang.email[i]);
                $('#labelflattype_consumer_view').text(lang.flattype[i]);
                $('#consumer_exit_view').text(lang.exit[i]);
                $('#h4_consumer_view').text(consumer_view_row.h4[i]);
//consumer_edit_row
                $('#labelowner_consumer_edit').text(lang.owner[i]);
                $('#labelstreet_consumer_edit').text(lang.street[i]);
                $('#labelhouse_consumer_edit').text(lang.house[i]);
                $('#labelflat_consumer_edit').text(lang.flat[i]);
                $('#labelphone_consumer_edit').text(lang.phone[i]);
                $('#labelemail_consumer_edit').text(lang.email[i]);
                $('#labelflattype_consumer_edit').text(lang.flattype[i]);
                $('#labelsign_auto_calc').text(lang.auto_calc[i]);
                $('#labelsign_auto_calc1').text(lang.yes[i]);
                $('#labelsign_auto_calc2').text(lang.no[i]);
                $('#labelcalc_start_day').text(lang.calc_start_day[i]);
                $('#h4_consumer_edit').text(consumer_edit_row.h4[i]);                
                $('#consumer_save_edit').text(lang.save[i]);$('#consumer_save_edit').prop('disabled', true);
                $('#consumer_exit_edit').text(lang.exit[i]);
//payment_sign_up
                $('#labelconsumer_id_addpay').text(lang.consumer[i]);
                $('#labeloper_day_addpay').text(lang.oper_day[i]);
                $('#labelpayment_sum_addpay').text(lang.payment_sum[i]);
                $('#labeldescription_addpay').text(lang.description[i]);
                $('#h4_payment_sign_up').text(payment_sign_up.h4[i]);
                $('#payment_save_add').text(lang.save[i]);$('#payment_save_add').prop('disabled', true);
                $('#payment_exit_add').text(lang.exit[i]);
// viewpay_row
                $('#labelpayment_id_viewpay').text(lang.payment_id[i]);
                $('#labelconsumer_viewpay').text(lang.consumer[i]);
                $('#labeloper_day_viewpay').text(lang.oper_day[i]);
                $('#labelupd_day_viewpay').text(lang.upd_day[i]);
                $('#labeldebet_sum_viewpay').text(lang.debet_sum[i]);
                $('#labelpayment_sum_viewpay').text(lang.paid[i]); 
                $('#labeldescription_viewpay').text(lang.description[i]);
                $('#h4_viewpay').text(payments_view_row.h4[i]);
                $('#payments_exit_view').text(lang.exit[i]);
// payments_edit_row
                $('#labelconsumer_id_editpay').text(lang.consumer[i]);
                $('#labelpayment_id_editpay').text(lang.payment_id[i]);
                $('#labeloper_day_editpay').text(lang.oper_day[i]);
                $('#labelupd_day_editpay').text(lang.upd_day[i]);
                $('#labeldebet_sum_editpay').text(lang.debet_sum[i]);
                $('#labelpayment_sum_editpay').text(lang.paid[i]); 
                $('#labeldescription_editpay').text(lang.description[i]);
                $('#h4_editpay').text(payments_edit_row.h4[i]);            
                $('#payment_save_edit').text(lang.save[i]);$('#payment_save_edit').prop('disabled', true);
                $('#payment_exit_edit').text(lang.exit[i]);
//-----------------------------------------------------------------------------------------
                $('#fbutton_apply').text(lang.apply[i]);$('#fbutton_clear').text(lang.clear[i]);
                $('#fbutton1_apply').text(lang.apply[i]);$('#fbutton1_clear').text(lang.clear[i]);
                $('#add').text(lang.add[i]);$('#padd').text(lang.add[i]);
                $('#save').text(lang.save[i]);$('#update').text(lang.update[i]);
                $('#exit').text(lang.exit[i]);
            }
//******************  viewConsumer            
            function viewConsumer(a, modal){
                if (modal) {
                    $('#owner' + a.consumer_id).text(a.owner);
                    $('#street' + a.consumer_id).text(a.street);
                    $('#house' + a.consumer_id).text(a.house);
                    $('#flat' + a.consumer_id).text(a.flat);
                    $('#code' + a.consumer_id).text(a.code);
                    $('#flattype' + a.consumer_id).text(a.type);
                    $('#phone' + a.consumer_id).text(a.phone);
                    $('#month_debet_sum' + a.consumer_id).text(a.month_debet_sum);
                    $('#balance' + a.consumer_id).text(a.balance);
                }
                else {
                    var array = '', count = 0;
                    $('#consumerTable tr').remove();
                    $('#listcode option[value]').remove();
                    $('#listowner option[value]').remove();
                    $('#liststreet option[value]').remove();
                    $('#listhouse option[value]').remove();
                    $('#listflat option[value]').remove();
                    $('#listflattype option[value]').remove();
                    $('#listphone option[value]').remove();
                    $('#listmonth_debet_sum option[value]').remove();
                    $('#listbalance option[value]').remove();
                    for (var j in a) {
                        array = $('#listcode option').map(function () {return this.value;}).get();
                        (!array.includes(a[j].code)) ? $('#listcode').append('<option value="' + a[j].code + '">') : '';
                        array = $('#listowner option').map(function () {return this.value;}).get();
                        (!array.includes(a[j].owner)) ? $('#listowner').append('<option value="' + a[j].owner + '">') : '';
                        array = $('#liststreet option').map(function () {return this.value;}).get();
                        (!array.includes(a[j].street)) ? $('#liststreet').append('<option value="' + a[j].street + '">') : '';
                        array = $('#listhouse option').map(function () {return this.value;}).get();
                        (!array.includes(a[j].house)) ? $('#listhouse').append('<option value="' + a[j].house + '">') : '';
                        array = $('#listflat option').map(function () {return this.value;}).get();
                        (!array.includes(a[j].flat)) ? $('#listflat').append('<option value="' + a[j].flat + '">') : '';
                        array = $('#listflattype option').map(function () {return this.value;}).get();
                        (!array.includes(a[j].type)) ? $('#listflattype').append('<option value="' + a[j].type + '">') : '';
                        array = $('#listphone option').map(function () {return this.value;}).get();
                        (!array.includes(a[j].phone)) ? $('#listphone').append('<option value="' + a[j].phone + '">') : '';
                        array = $('#listmonth_debet_sum option').map(function () {return this.value;}).get();
                        (!array.includes(a[j].month_debet_sum)) ? $('#listmonth_debet_sum').append('<option value="' + a[j].month_debet_sum + '">') : '';
                        array = $('#listbalance option').map(function () {return this.value;}).get();
                        (!array.includes(a[j].balance)) ? $('#listbalance').append('<option value="' + a[j].balance + '">') : '';
                        count++;
                        var data = {id: a[j].id, tar: count, code: a[j].code, owner: a[j].owner, street: a[j].street, house: a[j].house, flat: a[j].flat, flattype: a[j].type, phone: a[j].phone, month_debet_sum: a[j].month_debet_sum, balance: a[j].balance, title1: lang.view[i], title2: lang.edit[i], title3: lang.delete[i], confirm: lang.confirm[i] + ' ' + lang.yes[i] + '/' + lang.no[i], deleted: lang.deleted[i]};
                        var row = $('#rowTemplate').render(data);
                        $('#consumerTable').append(row);
                    }
                }
            }
//******************  viewPayments
            function viewPayments(a, modal){
                if (modal) {
                    $('#paytd' + a.payment_id).text(a.payment_sum);
                    $('#debettd' + a.payment_id).text(a.debet_sum);
                    $('#desctd' + a.payment_id).text(a.description);
                }
                else {
                    var desclang = lang.calculation[i], array = '';
                    $('#paymentTable tr').remove();
                    $('#listoper_day option[value]').remove();
                    $('#listpayment_sum option[value]').remove();
                    $('#listdebet_sum option[value]').remove();
                    $('#listdescription option[value]').remove();
                    $('#fbutton1_apply').prop('disabled', true);$('#fbutton1_clear').prop('disabled', true);
                    var count = 0;
                    for (var j in a) {
                        array = $('#listoper_day option').map(function () {return this.value;}).get();
                        (!array.includes(moment(a[j].oper_day).format('DD.MM.YYYY'))) ? $('#listoper_day').append('<option value="' + moment(a[j].oper_day).format('DD.MM.YYYY') + '">') : '';
                        array = $('#listpayment_sum option').map(function () {return this.value;}).get();
                        (!array.includes(a[j].payment_sum)) ? $('#listpayment_sum').append('<option value="' + a[j].payment_sum + '">') : '';
                        array = $('#listdebet_sum option').map(function () {return this.value;}).get();
                        (!array.includes(a[j].debet_sum)) ? $('#listdebet_sum').append('<option value="' + a[j].debet_sum + '">') : '';
                        array = $('#listdescription option').map(function () {return this.value;}).get();
                        (!array.includes(a[j].description)) ? $('#listdescription').append('<option value="' + a[j].description + '">') : '';
                        if (a[j].record_accrual == 1) {
                            switch (i) {
                                case '2': {desclang = lang.calculation[i] + a[j].description; break;}
                                case '3': {desclang = lang.calculation[i] + a[j].description; break;}
                                default: {desclang = a[j].description + lang.calculation[i]; break;}
                            }
                        } else {
                            desclang = a[j].description;
                        }
                        count++;
                        var data = {id: a[j].consumer_id, payment_id: a[j].id, tar1: count, oper_day: moment(a[j].oper_day).format('DD.MM.YYYY'), payment_sum: a[j].payment_sum, debet_sum: a[j].debet_sum, description: desclang, title1: lang.view[i], title2: lang.edit[i], title3: lang.delete[i], confirm: lang.confirm[i] + ' ' + lang.yes[i] + '/' + lang.no[i], deleted: lang.deleted[i]};
                        var row = $('#rowTemplate1').render(data);
                        $('#paymentTable').append(row);
                        $('#fbutton1_apply').prop('disabled', false);$('#fbutton1_clear').prop('disabled', false);
                    }
                }
            }
//******************  filterConsumer
            function filterConsumer(b, farray){
                fconsumers = b.filter(function (e) {
                    if (
                        (e.code.toUpperCase().search(farray['code'].toUpperCase()) != -1) &&
                        (e.owner.toUpperCase().search(farray['owner'].toUpperCase()) != -1) &&
                        (e.street.toUpperCase().search(farray['street'].toUpperCase()) != -1) &&
                        (e.house.toUpperCase().search(farray['house'].toUpperCase()) != -1) &&
                        (e.flat.toUpperCase().search(farray['flat'].toUpperCase()) != -1) &&
                        (e.type.toUpperCase().search(farray['flattype'].toUpperCase()) != -1) &&
                        (e.phone.search(farray['phone']) != -1) &&
                        (e.month_debet_sum.search(farray['month_debet_sum']) != -1) &&
                        (e.balance.search(farray['balance']) != -1)
                    ) {return true;}
                });
                viewConsumer(fconsumers, false);
            }
//******************  filterPayments
            function filterPayments(b, farray){
                fpayments = b.filter(function (e) {
                    if (
                        (moment(e.oper_day).format('DD.MM.YYYY').search(farray['oper_day']) != -1) &&
                        (e.payment_sum.search(farray['payment_sum']) != -1) &&
                        (e.debet_sum.search(farray['debet_sum']) != -1) &&
                        (e.description.toUpperCase().search(farray['description'].toUpperCase()) != -1)
                    ) {return true;}
                });
                viewPayments(fpayments, false);
            }
//******************  sortConsumer
            function sortConsumer(b, sfield, direction){
                a = b.sort(function (x, y) {
                    switch(sfield) {
                        case 'code' :
                            switch (direction) {
                                case 'NaN':  return x.id.localeCompare(y.id); break;
                                case 'Asc' : return x.code.localeCompare(y.code); break;
                                case 'Desc' : return y.code.localeCompare(x.code); break;
                            }
                            break;
                        case 'owner' :
                            switch (direction) {
                                case 'NaN':  return x.id.localeCompare(y.id); break;
                                case 'Asc' : return x.owner.localeCompare(y.owner); break;
                                case 'Desc' : return y.owner.localeCompare(x.owner); break;
                            }
                            break;
                        case 'street' :
                            switch (direction) {
                                case 'NaN':  return x.id.localeCompare(y.id); break;
                                case 'Asc' : return x.street.localeCompare(y.street); break;
                                case 'Desc' : return y.street.localeCompare(x.street); break;
                            }
                            break;
                        case 'house' :
                            switch (direction) {
                                case 'NaN':  return x.id.localeCompare(y.id); break;
                                case 'Asc' : return x.house.localeCompare(y.house); break;
                                case 'Desc' : return y.house.localeCompare(x.house); break;
                            }
                            break;
                        case 'flat' :
                            switch (direction) {
                                case 'NaN':  return x.id.localeCompare(y.id); break;
                                case 'Asc' : return x.flat.localeCompare(y.flat); break;
                                case 'Desc' : return y.flat.localeCompare(x.flat); break;
                            }
                            break;        
                        case 'flattype' :
                            switch (direction) {
                                case 'NaN':  return x.id.localeCompare(y.id); break;
                                case 'Asc' : return x.type.localeCompare(y.type); break;
                                case 'Desc' : return y.type.localeCompare(x.type); break;
                            }
                            break;
                        case 'phone' :
                            switch (direction) {
                                case 'NaN':  return x.id.localeCompare(y.id); break;
                                case 'Asc' : return x.phone.localeCompare(y.phone); break;
                                case 'Desc' : return y.phone.localeCompare(x.phone); break;
                            }
                            break;
                        case 'month_debet_sum' :
                            switch (direction) {
                                case 'NaN':  return x.id.localeCompare(y.id); break;
                                case 'Asc' : return x.month_debet_sum.localeCompare(y.month_debet_sum); break;
                                case 'Desc' : return y.month_debet_sum.localeCompare(x.month_debet_sum); break;
                            }
                            break;
                        case 'balance' :
                            switch (direction) {
                                case 'NaN':  return x.id.localeCompare(y.id); break;
                                case 'Asc' : return x.balance.localeCompare(y.balance); break;
                                case 'Desc' : return y.balance.localeCompare(x.balance); break;
                            }
                            break;
                    } 
                });
                viewConsumer(a, false);
            }
//******************  sortPayments
            function sortPayments(b, sfield, direction){
                a = b.sort(function (x, y) {
                    switch(sfield) {
                        case 'oper_day' :
                            switch (direction) {
                                case 'NaN':  return x.id - y.id; break;
                                case 'Asc' : return moment(x.oper_day, 'YYYY-MM-DD') - moment(y.oper_day, 'YYYY-MM-DD'); break;
                                case 'Desc' : return moment(y.oper_day, 'YYYY-MM-DD') - moment(x.oper_day, 'YYYY-MM-DD'); break;
                            }
                            break;
                        case 'payment_sum' :
                            switch (direction) {
                                case 'NaN':  return x.id - y.id; break;
                                case 'Asc' : return x.payment_sum - y.payment_sum; break;
                                case 'Desc' : return y.payment_sum - x.payment_sum; break;
                            }
                        case 'debet_sum' :
                            switch (direction) {
                                case 'NaN':  return x.id - y.id; break;
                                case 'Asc' : return x.debet_sum - y.debet_sum; break;
                                case 'Desc' : return y.debet_sum - x.debet_sum; break;
                            }
                            break;
                            break;
                        case 'description' :
                            switch (direction) {
                                case 'NaN':  return x.id - y.id; break;
                                case 'Asc' : return x.description - y.description; break;
                                case 'Desc' : return y.description - x.description; break;
                            }
                            break;
                    } 
                });
                viewPayments(a, false);
            }
//******************  ReloadConsumer
            function ReloadConsumer(){
                $.ajax ({
                    url: 'consumers.php',
                    type: 'POST',
                    data: ({user_id: '<?= $_SESSION['user_id']; ?>'}),
                    dataType: 'html',
                    success: function(data) {data = JSON.parse(data);
                        if (data != 'flattype_empty') {fconsumers = consumers = data; viewConsumer(consumers, false)}
                    }
                });
            }
//******************  ReloadPayments
            function ReloadPayments(j){
                $.ajax ({
                    url: 'getpayments.php',
                    type: 'POST',
                    data: ({ConsumersId: $(j).attr('consumersId')}),
                    dataType: 'html',
                    success: function(data) {
                        fpayments = payments = JSON.parse(data);
                        viewPayments(payments, false);
                    }
                });
            }
//-----------------------------------------------            
            $(document).ready (function () {
                $('#padd').prop('disabled', true);
                $('#fbutton1_apply').prop('disabled', true);
                $('#fbutton1_clear').prop('disabled', true);
                $('#add, #padd, #update, #exit').bind('click', function(){
                    switch ($(this).attr('id')) {
                        case 'add': {showConsumer_sign_up(shirkat_id, district_id); break;}
                        case 'padd': {if (consumerid_for_payment != undefined) {showPayment_sign_up(consumerid_for_payment);} break;}
                        case 'update': {$(location).attr('href', '/consumer_form.php'); break;}
                        case 'exit': {$(location).attr('href', '/index.php'); break;}
                    }
                });
                $('#accrual').bind('click', function (){
                    var msglang;
                    var value = prompt(consumer_form.accrual_date[i], moment().format('DD.MM.YYYY'));
                    if (!(value == null)) {
                        value = moment(value, 'DD.MM.YYYY').format('YYYY-MM-DD');
                        if (!(value == 'Invalid date')) {
                            var date_descmsglang = moment(value).format('MM.YYYY');
                            switch (i) {
                                case '2': {msglang = 'За ' + date_descmsglang + consumer_form.msg[i]; break;}
                                case '3': {msglang = consumer_form.msg[i] + date_descmsglang + ' was charged'; break;}
                                default: {msglang = date_descmsglang + consumer_form.msg[i]; break;}
                            }
                            $.ajax ({
                                url: 'accrual.php',
                                type: 'POST',
                                data: ({
                                    shirkatid: shirkat_id,
                                    oper_day: value,
                                    description: date_descmsglang
                                }),
                                dataType: 'html',
                                success: function(data) {
                                  if (data == 1) {alert(msglang); $(location).attr('href', 'consumer_form.php');} 
                                }
                            });
                        } else {
                            alert(consumer_form.msg_err[i]);
                        }
                    }
                });
                $('#trsort th, #trsort1 th').bind('click', function (){
                    if (!($(this).attr('name') == undefined)) {
                        switch($(this).attr('value')) {
                            case 'NaN' : $(this).attr('value', 'Asc'); $(this).attr('id', lang[$(this).attr('name')][i]/* + ' ↓'*/); break;
                            case 'Asc' : $(this).attr('value', 'Desc'); $(this).attr('id', lang[$(this).attr('name')][i]/* + ' ↓'*/); break;
                            case 'Desc' : $(this).attr('value', 'NaN'); $(this).attr('id', lang[$(this).attr('name')][i]); break;
                        }
                        if ($(this).parent('tr').attr('id') == 'trsort') {sortConsumer(fconsumers, $(this).attr('name'), $(this).attr('value'));
                        } else {
                            sortPayments(fpayments, $(this).attr('name'), $(this).attr('value'));
                        }
                    }
                });
                $('#fbutton_apply, #fbutton1_apply, #fbutton_clear, #fbutton1_clear').bind('click', function () {
                    switch ($(this).attr('id')) {
                        case 'fbutton_apply': {
                                                if (!(
                                                        ($('#fcode').val() == '') && 
                                                        ($('#fowner').val() == '') && 
                                                        ($('#fstreet').val() == '') && 
                                                        ($('#fhouse').val() == '') && 
                                                        ($('#fflat').val() == '') && 
                                                        ($('#fflattype').val() == '') && 
                                                        ($('#fphone').val() == '') &&
                                                        ($('#fmonth_debet_sum').val() == '') &&
                                                        ($('#fbalance').val() == '')
                                                    )) {
                                                        farray = {
                                                            'code' : $('#fcode').val(),
                                                            'owner' : $('#fowner').val(),
                                                            'street' : $('#fstreet').val(),
                                                            'house' : $('#fhouse').val(),
                                                            'flat' : $('#fflat').val(),
                                                            'flattype' : $('#fflattype').val(),
                                                            'phone' : $('#fphone').val(),
                                                            'month_debet_sum' : $('#fmonth_debet_sum').val(),
                                                            'balance' : $('#fbalance').val()
                                                        }
                                                        filterConsumer(consumers, farray);
                                                       } else {fconsumers = consumers;viewConsumer(consumers, false)}
                                                break;
                        }
                        case 'fbutton_clear': {
                                                $('#fcode').val(''); 
                                                $('#fowner').val(''); 
                                                $('#fstreet').val(''); 
                                                $('#fhouse').val(''); 
                                                $('#fflat').val(''); 
                                                $('#fflattype').val(''); 
                                                $('#fphone').val('');
                                                $('#fmonth_debet_sum').val('');
                                                $('#fbalance').val('');
                                                break;
                        }
                        case 'fbutton1_apply': {
                                                if (!(
                                                        ($('#foper_day').val() == '') && 
                                                        ($('#fpayment_sum').val() == '') && 
                                                        ($('#fdebet_sum').val() == '') && 
                                                        ($('#fdescription').val() == '')
                                                    )) {
                                                        farray = {
                                                            'oper_day' : $('#foper_day').val(),
                                                            'payment_sum' : $('#fpayment_sum').val(),
                                                            'debet_sum' : $('#fdebet_sum').val(),
                                                            'description' : $('#fdescription').val()
                                                        }
                                                        filterPayments(payments, farray)
                                                    } else {fpayments = payments;viewPayments(payments, false)}
                                                break;
                        }
                        case 'fbutton1_apply': {
                                                if (!(
                                                        ($('#foper_day').val() == '') && 
                                                        ($('#fpayment_sum').val() == '') && 
                                                        ($('#fdebet_sum').val() == '') && 
                                                        ($('#fdescription').val() == '')
                                                    )) {
                                                        farray = {
                                                            'oper_day' : $('#foper_day').val(),
                                                            'payment_sum' : $('#fpayment_sum').val(),
                                                            'debet_sum' : $('#fdebet_sum').val(),
                                                            'description' : $('#fdescription').val()
                                                        }
                                                        filterPayments(payments, farray)
                                                    } else {fpayments = payments;viewPayments(payments, false)}
                                                break;
                        }
                        case 'fbutton1_clear': {
                                                $('#foper_day').val(''); 
                                                $('#fpayment_sum').val(''); 
                                                $('#fdebet_sum').val(''); 
                                                $('#fdescription').val('');
                                                break;
                        }
                    }
                });
                ReloadConsumer();
            });
            function trclick(j){
                if (!(cursor == undefined)) {cursor.style.backgroundColor = '';}
                consumerid_for_payment = $(j).attr('consumersId');
                localStorage.setItem('localcursor', '#'+consumerid_for_payment);
                cursor = j;
                j.style.backgroundColor = '#2f73a3';
                $.ajax ({
                    url: 'getpayments.php',
                    type: 'POST',
                    data: ({ConsumersId: $(j).attr('consumersId')}),
                    dataType: 'html',
                    beforeSend: function () {
                        $('#foper_day').val(''); 
                        $('#fpayment_sum').val(''); 
                        $('#fdebet_sum').val(''); 
                        $('#fdescription').val('');
                    },
                    success: function(data) {$('#padd').prop('disabled', false);
                        if (!(data == 0)) {
                            fpayments = payments = JSON.parse(data);
                            sortPayments(payments, 'oper_day', 'Desc');
                        } else {
                            ReloadPayments(j)/*; alert(lang.msg_no[i]);*/
                        }
                    }
                });
            }
            /* Когда пользователь нажимает кнопку, переключаться между
               скрытием и отображением раскрывающегося содержимого */
            function DropdownButton() {
              document.getElementById("myDropdown").classList.toggle("show");
            }
            // Закройте раскрывающийся список, если пользователь щелкнет за его пределами.
            window.onclick = function(event) {
              if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                  var openDropdown = dropdowns[i];
                  if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                  }
                }
              }
            }
        </script>
    </head>
    <body onload='setLang()'>
<?php
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
        echo
            "
            <div class='container'>
                <div class='top-info'>
                    <div style='text-align: center; width: 15%'>
                        <img src = 'img/ubs2.png'>
                    </div>
                <div style='text-align: center; width: 85%'>
                    <ul>
                        <add>
                            <li id='li1'></li>" . $_SESSION['name_region'] . "
                            <li id='li2'></li>" . $_SESSION['name_district'] . "
                            <li id='li3'></li>" . $_SESSION['mahalla'] . "
                        </add>
                    </ul>
                    <add><span id='pha'></span>: " . $_SESSION['name_shirkat'] . "</add>
                </div>
            </div>
            <hr><div class='clr'></div>"
?>            
        <div class='scroll-table'>
            <div class='title'>
                <div>
                    <button id='add' class='btn-danger'></button>
                    <button id='accrual' class='btn-danger' value='1'></button>
                    <button id='update' class='btn-danger'></button>
                    <button id='exit' class='btn-danger'></button>
                </div>
                <div><h3 id='list_flats'></h3> </div>
                <div class="dropdown">
                  <a class="dropbtn"><img id='settings' src = 'img/settings.png' class='avatar' align='right'></a>
                  <div class="dropdown-content">
                      <a id='change_of_personal_data' href='/change_of_personal_data.php'></a>
                      <a id='flattype' href='/flattype_form.php'></a>
                      <a id='login' href='/change_login.php'></a>
                      <a id='psw' href='/change_psw.php'></a>
                  </div>
                </div>
            </div>
            <table id='consTable'>
                <thead>
                    <tr id='trsort'>
                        <th class='tar' style='width: 5%'>№:</th>
                        <th class='code' style='width: 6%' id='th1' name='code' value='NaN'></th>
                        <th class='owner' style='width: 23%' id='th2' name='owner' value='NaN'></th>
                        <th class='street' style='width: 15%' id='th3' name='street' value='NaN'></th>
                        <th class='house' style='width: 6%' id='th4' name='house' value='NaN'></th>
                        <th class='flat' style='width: 6%' id='th5' name='flat' value='NaN'></th>
                        <th class='flattype' style='width: 7%' id='th6' name='flattype' value='NaN'></th>
                        <th class='phone' style='width: 7%' id='th7' name='phone' value='NaN'></th>
                        <th class='month_debet_sum' style='width: 7%' id='th8' name='month_debet_sum' value='NaN'></th>
                        <th class='balance' style='width: 8%' id='th13' name='balance' value='NaN'></th>
                        <th class='actions' style='width: 10%' id='th9'></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th><input list='listcode' id='fcode' type='text'><datalist id='listcode'></datalist></th>
                        <th><input list='listowner' id='fowner' type='text'><datalist id='listowner'></datalist></th>
                        <th><input list='liststreet' id='fstreet' type='text'><datalist id='liststreet'></datalist></th>
                        <th><input list='listhouse' id='fhouse' type='text'><datalist id='listhouse'></datalist></th>
                        <th><input list='listflat' id='fflat' type='text'><datalist id='listflat'></datalist></th>
                        <th><input list='listflattype' id='fflattype' type='text'><datalist id='listflattype'></datalist></th>
                        <th><input list='listphone' id='fphone' type='text'><datalist id='listphone'></datalist></th>
                        <th><input list='listmonth_debet_sum' id='fmonth_debet_sum'><datalist id='listmonth_debet_sum'></datalist></th>
                        <th><input list='listbalance' id='fbalance' type='text'><datalist id='listbalance'></datalist></th>
                        <th><button id='fbutton_apply' class='btn-danger' value='1'></button><button id='fbutton_clear' class='btn-danger' value='1'></button></th>
                    </tr>
                </thead>
            </table>
            <div class="scroll-table-body"><table><tbody id='consumerTable'></tbody></table></div>
        </div>
            <div class='title'>
                <div><button  id = 'padd' class='btn-danger'></button></div>
                <div><h3 id='arrears'></h3></div>
                <div></div>
            </div>
        <div class='scroll-table'>
            <table>
                <thead>
                    <tr id='trsort1'>
                        <th class='tar1' style='width: 9%'>№:</th>
                        <th class='oper_day' id='th10' name='oper_day' value='NaN'></th>
                        <th class='payment_sum' id='th12' name='payment_sum' value='NaN'></th>
                        <th class='debet_sum' id='th11' name='debet_sum' value='NaN'></th>
                        <th class='description' id='th14' style='width: 30%' name='description' value='NaN'></th>
                        <th class='actions' id='th15'></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th><input list='listoper_day' id='foper_day' type='text'><datalist id='listoper_day'></datalist></th>
                        <th><input list='listpayment_sum' id='fpayment_sum' type='text'><datalist id='listpayment_sum'></datalist></th>
                        <th><input list='listdebet_sum' id='fdebet_sum' type='text'><datalist id='listdebet_sum'></datalist></th>
                        <th><input list='listdescription' id='fdescription' type='text'><datalist id='listdescription'></datalist></th>
                        <th><button id='fbutton1_apply' class='btn-danger' value='1'></button><button id='fbutton1_clear' class='btn-danger' value='1'></button></th>
                    </tr>
                </thead>
            </table>
            <div class='scroll-table-body'><table><tbody id = 'paymentTable'></tbody></table></div>
        </div>
<!-- Модальные окна -->
<!-- consumer_sign_up_add -->
        <div id='container_addcons'>
            <div id='addcons'>
                <div class='about-banner'><h4 id='h4_consumer_sign_up'></h4></div>
                <div class='row_modal'>
                    <div class='col_modal_label'>
                        <label id='labelowner_addcons' for='owner_addcons'></label><br><br>
                        <label id='labelstreet_addcons' for='street_addcons'></label><br><br>
                        <label id='labelhouse_addcons' for='house_addcons'></label><br><br>
                        <label id='labelflat_addcons' for='flat_addcons'></label><br><br>
                        <label id='labelphone_addcons' for='phone_addcons'></label><br><br>
                        <label id='labelemail_addcons' for='email_addcons'></label><br><br>
                        <label id='labelselectflattype_addcons' for='flattype_addcons'></label><br><br>
                    </div>
                    <div class='col_modal'>
                        <input id='inputowner_addcons' type='text' name='owner_addcons'><br><br>
                        <input id='inputstreet_addcons' type='text' style='width: 70%' name='street_addcons'><br><br>
                        <input id='inputhouse_addcons' type='text' style='width: 20%' name='house_addcons'><br><br>
                        <input id='inputflat_addcons' type='text' style='width: 20%' name='flat_addcons'><br><br>
                        <input id='inputphone_addcons' type='tel' style='width: 30%' name='phone_addcons'><br><br>
                        <input id='inputemail_addcons' type='email' style='width: 60%' name='email_addcons'><br><br>
                        <select id='selectflattype_addcons' style='width: 35%' name='flattype_addcons'></select><br>
                    </div>
                </div>
                <button id='register_consumer_sign_up'></button>
                <button id='consumer_exit_add'></button>
            </div>
        </div>
<!-- consumer_view_row -->
        <div id='container_viewcons'>
            <div id='viewcons'>
                <div class='about-banner'><h4 id='h4_consumer_view'></h4></div>
                <div class='row_modal'>
                    <div class='col_modal_label'>
                        <label id='labelowner_consumer_view'></label><br><br>
                        <label id='labelstreet_consumer_view'></label><br><br>
                        <label id='labelhouse_consumer_view'></label><br><br>
                        <label id='labelflat_consumer_view'></label><br><br>
                        <label id='labelphone_consumer_view'></label><br><br>
                        <label id='labelemail_consumer_view'></label><br><br>
                        <label id='labelflattype_consumer_view'></label><br><br>
                    </div>
                    <div class='col_modal'>
                        <b id='owner_consumer_view'></b><br><br>
                        <b id='street_consumer_view'></b><br><br>
                        <b id='house_consumer_view'></b><br><br>
                        <b id='flat_consumer_view'></b><br><br>
                        <b id='phone_consumer_view'></b><br><br>
                        <b id='email_consumer_view'></b><br><br>
                        <b id='type_consumer_view'></b><br><br>
                    </div>
                </div>
                <button id='consumer_exit_view'></button>
            </div>
        </div>
<!-- consumer_edit_row -->
        <div id='container_editcons'>
            <div id='editcons'>
                <div class='about-banner'><h4 id='h4_consumer_edit'></h4></div>
                <div class='row_modal'>
                    <div class='col_modal_label'>
                        <label id='labelowner_consumer_edit' for='owner_editcons'></label><br><br>
                        <label id='labelstreet_consumer_edit' for='street_editcons'></label><br><br>
                        <label id='labelhouse_consumer_edit' for='house_editcons'></label><br><br>
                        <label id='labelflat_consumer_edit' for='flat_editcons'></label><br><br>
                        <label id='labelphone_consumer_edit' for='phone_editcons'></label><br><br>
                        <label id='labelemail_consumer_edit' for='email_editcons'></label><br><br>
                        <label id='labelflattype_consumer_edit'></label><br><br>
                        <label id='labelsign_auto_calc'></label><br><br>
                        <label id='labelcalc_start_day'></label><br><br>
                    </div>
                    <div class='col_modal'>
                        <diveditcons>
                            <input id='inputowner_consumer_edit' name='owner_editcons'><br><br> 
                            <input id='inputstreet_consumer_edit' style='width: 20%' name='street_editcons'><br><br> 
                            <input id='inputhouse_consumer_edit' style='width: 20%' name='house_editcons'><br><br> 
                            <input id='inputflat_consumer_edit' style='width: 20%' name='flat_editcons'><br><br> 
                            <input id='inputphone_consumer_edit' type='tel' style='idth: 30%' name='phone_editcons'><br><br> 
                        </diveditcons>
                        <input id='inputemail_consumer_edit' type='email' style='width: 60%' name='email_editcons'><br><br>
                        <select id='selectflattype_consumer_edit' style='width: 35%'></select><br><br>
                        <input id='inputsign_auto_calc1' type='radio' name='sign' style='width: 10%' value='Y'>
                        <label id='labelsign_auto_calc1' for='inputsign_auto_calc1'></label>
                        <input id='inputsign_auto_calc2' type='radio' name='sign' style='width: 10%' value='N'>
                        <label id='labelsign_auto_calc2' for='inputsign_auto_calc2'></label><br><br>
                        <input id='inputcalc_start_day' style='width: 35%' type='date'>
                    </div>
                </div>
                <button id='consumer_save_edit'></button>
                <button id='consumer_exit_edit'></button>
            </div>  <!-- editcons -->
        </div>
<!-- payment_sign_up_add -->
        <div id='container_addpay'>
            <div id='addpay'>
                <div class='about-banner'><h4 id='h4_payment_sign_up'></h4></div>
                <div class='row_modal'>
                    <div class='col_modal_label'>
                        <label id='labelconsumer_id_addpay'></label><br><br>
                        <label id='labeloper_day_addpay' for='oper_day_addpay'></label><br><br>
                        <label id='labelpayment_sum_addpay' for='payment_sum_addpay'></label><br><br>
                        <label id='labeldescription_addpay' for='description_addpay'></label><br><br>
                    </div>
                    <div class='col_modal'>
                        <b id='owner_for_payment_sign_up' style='font-size: 20px; color: blue'></b><br><br>
                        <input id='inputoper_day_addpay' style='width: 60%' type='date' name='oper_day_addpay'><br>
                        <label id='inputoper_dayempty_addpay' style='color: red;'></label><br>
                        <input id='inputpayment_sum_addpay' style='width: 50%' type='number' name='payment_sum_addpay' required><br>
                        <label id='inputpayment_sumempty_addpay' style='color: red;'></label><br>
                        <textarea id='description_addpay' name='description_addpay'></textarea><br><br>
                    </div>
                </div>
                <button id='payment_save_add'></button>
                <button id='payment_exit_add'></button>
            </div>
        </div>
<!-- viewpay_row -->
        <div id='container_viewpay'>
            <div id='viewpay'>
                <div class='about-banner'><h4 id='h4_viewpay'></h4></div>
                   <label id='labelconsumer_viewpay'></label>
                    <b id='owner_viewpay' style='font-size: 20px;'></b>
                    <div class='scroll-table'>
                        <table id='table_viewpay'>
                            <thead>
                                <tr>
                                  <th style='width: 5%'>№</th>
                                  <th id='labeloper_day_viewpay' style='width: 10%'></th>
                                  <th id='labeldebet_sum_viewpay' style='width: 12%'></th>
                                  <th id='labelpayment_sum_viewpay' style='width: 12%'></th>
                                  <th id='labeldescription_viewpay' style='width: 46%'></th>
                                  <th id='labelupd_day_viewpay' style='width: 15%'></th>
                                </tr>
                            </thead>
                        </table>   
                        <div class='scroll-table-body'><table id='remove'><tbody id='payment_history'></tbody></table></div>
                        <button id='payments_exit_view'></button>
                    </div>
            </div>
        </div>
<!-- payments_edit_row -->
        <div id='container_editpay'>
            <div id='editpay'>
                <div class='about-banner'><h4 id='h4_editpay'></h4></div>
                <div class='row_modal'>
                    <div class='col_modal_label'>
                        <label id='labelconsumer_id_editpay'></label><br><br>
                        <label id='labeloper_day_editpay'></label><br><br>
                        <label id='labeldebet_sum_editpay' for='debet_sum_editpay'></label><br><br>
                        <label id='labelpayment_sum_editpay' for='payment_sum_editpay'></label><br><br>
                        <label id='labeldescription_editpay' for='description_editpay'></label><br><br>
                    </div>
                    <div class='col_modal'>
                        <b id='owner_editpay'></b><br><br>
                        <b id='oper_day_editpay'></b><br><br>
                        <input id='debet_sum_editpay' style='width: 30%;' type='number' name='debet_sum_editpay'><br><br>
                        <input id='payment_sum_editpay' style='width: 30%;' type='number' name='payment_sum_editpay'><br><br>
                        <textarea id='description_editpay' style='width: 60%;' name='description_editpay'></textarea><br><br>
                    </div>
                </div>
                <button id='payment_save_edit'></button>
                <button id='payment_exit_edit'></button>
            </div>
        </div>
   
    </body>
</html>