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
        <script src="js/jsrender.js"></script>
        <script src="js/modal_windows/flattype_sign_up.js"></script>
        <script src="js/modal_windows/flattype_edit_row.js"></script>
        <script src="js/langs.js"></script>
        <script id="rowTemplate" type="text/x-jsrender">
            <tr onclick='trclick(this)' id={{>id}} flattypesId={{>id}}>
                <td class='tar' style='text-align: right; width: 5%'>{{>tar}}</td>
                <td class='flattype' id='flattype{{>id}}' style='width: 23%'>{{>flattype}}</td>
                <td class='month_debet_sum' id='month_debet_sum{{>id}}' style='text-align: right; width: 15%'>{{>month_debet_sum}}</td>
                <td class='field' id='field{{>id}}' style='text-align: right; width: 6%'>{{>field}}</td>
                <td class='actions' style='text-align: center; width: 10%;'>
                    <!-- <a href = '#' onclick = 'showFlattype_view_row({{>id}})'><img src = 'ico/view.ico' title = '{{>title1}}'></a> -->
                    <a href = '#' onclick = 'showFlattype_edit_row({{>id}})'><img src = 'ico/edit.ico' title = '{{>title2}}'></a>
                    <a href = 'delete_row.php?id={{>id}}&field=type&table=flattypes&deleted={{>deleted}}' onclick="return confirm('{{>confirm}}?')"><img src = 'ico/delete.ico' title = '{{>title3}}'></a>
                </td>
            </tr>
        </script>
        <script type="text/javascript">
            var cursor, flattypes, fflattypes;
            var i = '<?php echo $_SESSION['langId']?>';
            var shirkatId = '<?php echo $_SESSION['shirkat_id']?>';
            var modal = false;
            function setLang(){
//flattype_form            
                document.title = lang.title[i];
                $('#pha').text(lang.pha[i]); $('#list_flattypes').text(flattype_sign_up.list_flattypes[i]);$('#arrears').text(lang.arrears[i]);
                $('#li1').text(lang.region[i]);$('#li2').text(lang.city[i]);$('#li3').text(lang.mahalla[i]);
                $('#th2').text(lang.flattype[i]);$('#th3').text(lang.month_debet_sum[i]);
                $('#th4').text(flattype_sign_up.labelfield[i]);
                $('#th5').text(lang.actions[i]);
//flattype_sign_up
                $('#labelflattype_addflattype').text(lang.flattype[i]);
                $('#labelmonth_debet_sum_addflattype').text(lang.month_debet_sum[i]);
                $('#labelfield_addflattype').text(flattype_sign_up.labelfield[i]);
                $('#labelselectflattype_addflattype').text(lang.flattype[i]);
                $('#inputflattype_addflattype').attr('placeholder', flattype_sign_up.labelflattype[i]);
                $('#inputmonth_debet_sum_addflattype').attr('placeholder', lang.month_debet_sum[i]);
                $('#inputfield_addflattype').attr('placeholder', flattype_sign_up.labelfield[i]);
                $('#flattype_save_add').text(lang.save[i]);$('#flattype_save_add').prop('disabled', true);
                $('#flattype_exit_add').text(lang.exit[i]);
                $('#h4_flattype_sign_up').text(flattype_sign_up.h2[i]);
//flattype_edit_row
                $('#labelflattype_edit').text(lang.flattype[i]);
                $('#labelmonth_debet_sum_edit').text(lang.month_debet_sum[i]);
                $('#labelfield_edit').text(flattype_sign_up.labelfield[i]);
                $('#h4_flattype_edit').text(flattype_edit_row.h4[i]);                
                $('#flattype_save_edit').text(lang.save[i]);$('#flattype_save_edit').prop('disabled', true);
                $('#flattype_exit_edit').text(lang.exit[i]);
// -----------------------------------------------------------------------------------------
                $('#fbutton_apply').text(lang.apply[i]);$('#fbutton_clear').text(lang.clear[i]);
                $('#add').text(lang.add[i]);
                $('#save').text(lang.save[i]);$('#update').text(lang.update[i]);
                $('#exit').text(lang.exit[i]);
            }
//******************  viewFlattype
            function viewFlattype(a, modal){
                if (modal) {
                    $('#flattype' + a.type_id).text(a.type);
                    $('#month_debet_sum' + a.type_id).text(a.month_debet_sum);
                    $('#field' + a.type_id).text(a.field);
                }
                else {
                    var array = '', count = 0;
                    $('#flattypeTable tr').remove();
                    $('#listflattype option[value]').remove();
                    $('#listmonth_debet_sum option[value]').remove();
                    $('#listfield option[value]').remove();
                    for (var j in a) {
                        array = $('#listflattype option').map(function () {return this.value;}).get();
                        (!array.includes(a[j].type)) ? $('#listflattype').append('<option value="' + a[j].type + '">') : '';
                        array = $('#listmonth_debet_sum option').map(function () {return this.value;}).get();
                        (!array.includes(a[j].month_debet_sum)) ? $('#listmonth_debet_sum').append('<option value="' + a[j].month_debet_sum + '">') : '';
                        array = $('#listfield option').map(function () {return this.value;}).get();
                        (!array.includes(a[j].field)) ? $('#listfield').append('<option value="' + a[j].field + '">') : '';
                        count++;
                        var data = {id: a[j].id, tar: count, flattype: a[j].type, month_debet_sum: a[j].month_debet_sum, field: a[j].field, title1: lang.view[i], title2: lang.edit[i], title3: lang.delete[i], confirm: lang.confirm[i] + ' ' + lang.yes[i] + '/' + lang.no[i], deleted: lang.deleted[i]};
                        var row = $('#rowTemplate').render(data);
                        $('#flattypeTable').append(row);
                    }
                }
            }
//******************  filterFlattype
            function filterFlattype(b, farray){
                fflattypes = b.filter(function (e) { 
                    if (
                        (e.type.toUpperCase().search(farray['type'].toUpperCase()) != -1) &&
                        (e.month_debet_sum.toUpperCase().search(farray['month_debet_sum'].toUpperCase()) != -1) &&
                        (e.field.toUpperCase().search(farray['field'].toUpperCase()) != -1)
                    ) {return true;}
                });
                viewFlattype(fflattypes, false);
            }
//******************  sortFlattype
            function sortFlattype(b, sfield, direction){
                a = b.sort(function (x, y) {
                    switch(sfield) {
                        case 'flattype' :
                            switch (direction) {
                                case 'NaN':  return x.id.localeCompare(y.id); break;
                                case 'Asc' : return x.type.localeCompare(y.type); break;
                                case 'Desc' : return y.type.localeCompare(x.type); break;
                            }
                            break;
                        case 'month_debet_sum' :
                            switch (direction) {
                                case 'NaN':  return x.id.localeCompare(y.id); break;
                                case 'Asc' : return x.month_debet_sum.localeCompare(y.month_debet_sum); break;
                                case 'Desc' : return y.month_debet_sum.localeCompare(x.month_debet_sum); break;
                            }
                            break;
                        case 'field' :
                            switch (direction) {
                                case 'NaN':  return x.id.localeCompare(y.id); break;
                                case 'Asc' : return x.field.localeCompare(y.field); break;
                                case 'Desc' : return y.field.localeCompare(x.field); break;
                            }
                            break;        
                    } 
                });
                viewFlattype(a, false);
            }
//******************  sortFlattype
            function ReloadFlattype(){
                $.ajax ({
                    url: 'flattype.php',
                    type: 'POST',
                    data: ({shirkat_id: shirkatId}),
                    dataType: 'html',
                    success: function(data) {data = JSON.parse(data);
                        fflattypes = flattypes = data; viewFlattype(flattypes, false)
                    }
                });
            }
            $(document).ready (function () {
                $('#add, #update, #exit').bind('click', function(){
                    switch ($(this).attr('id')) {
                        case 'add': {showFlattype_sign_up(shirkatId); break;}
                        case 'update': {$(location).attr('href', '/flattype_form.php'); break;}
                        case 'exit': {$(location).attr('href', '/consumer_form.php'); break;}
                    }
                });
                $('#trsort th').bind('click', function (){
                    if (!($(this).attr('name') == undefined)) {
                        switch($(this).attr('value')) {
                            case 'NaN' : $(this).attr('value', 'Asc'); $(this).attr('id', lang[$(this).attr('name')][i]/* + ' ↓'*/); break;
                            case 'Asc' : $(this).attr('value', 'Desc'); $(this).attr('id', lang[$(this).attr('name')][i]/* + ' ↓'*/); break;
                            case 'Desc' : $(this).attr('value', 'NaN'); $(this).attr('id', lang[$(this).attr('name')][i]); break;
                        }
                        if ($(this).parent('tr').attr('id') == 'trsort') {sortFlattype(fflattypes, $(this).attr('name'), $(this).attr('value'));
                        } 
                    }
                });
                $('#fbutton_apply, #fbutton_clear').bind('click', function () {
                    switch ($(this).attr('id')) {
                        case 'fbutton_apply': {
                                                if (!(
                                                        ($('#fflattype').val() == '') && 
                                                        ($('#fmonth_debet_sum').val() == 0) && 
                                                        ($('#ffield').val() == 0)
                                                    )) {
                                                        farray = {
                                                            'type' : $('#fflattype').val(),
                                                            'month_debet_sum' : $('#fmonth_debet_sum').val(),
                                                            'field' : $('#ffield').val()
                                                        }
                                                        filterFlattype(flattypes, farray);
                                                        } else {fflattypes = flattypes;viewFlattype(flattypes, false)}
                                                break;
                        }
                        case 'fbutton_clear': {
                                                $('#fflattype').val(''); 
                                                $('#fmonth_debet_sum').val(''); 
                                                $('#ffield').val(''); 
                                                break;
                        }
                    }
                });
                ReloadFlattype();
            });
            function trclick(j){
                if (!(cursor == undefined)) {cursor.style.backgroundColor = '';}
                consumerid_for_payment = $(j).attr('flattypesId');
                localStorage.setItem('localcursor', '#'+consumerid_for_payment);
                cursor = j;
                j.style.backgroundColor = '#2f73a3';
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
                    <button id='update' class='btn-danger'></button>
                    <button id='exit' class='btn-danger'></button>
                </div>
                <div><h3 id='list_flattypes'></h3></div>
            </div><hr>
            <table id='consTable'>
                <thead>
                    <tr id='trsort'>
                        <th class='tar' style='width: 5%'>№:</th>
                        <th class='flattype' style='width: 23%' id='th2' name='flattype' value='NaN'></th>
                        <th class='month_debet_sum' style='width: 15%' id='th3' name='month_debet_sum' value='NaN'></th>
                        <th class='field' style='width: 6%' id='th4' name='field' value='NaN'></th>
                        <th class='actions' style='width: 10%' id='th5'></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th><input list='listflattype' id='fflattype' type='text'><datalist id='listflattype'></datalist></th>
                        <th><input list='listmonth_debet_sum' id='fmonth_debet_sum' type='text'><datalist id='listmonth_debet_sum'></datalist></th>
                        <th><input list='listfield' id='ffield' type='text'><datalist id='listfield'></datalist></th>
                        <th><button id='fbutton_apply' class='btn-danger' value='1'></button><button id='fbutton_clear' class='btn-danger' value='1'></button></th>
                    </tr>
                </thead>
            </table>
            <div class="scroll-table-body"><table><tbody id='flattypeTable'></tbody></table></div>
        </div>
<!-- Модальные окна -->
<!-- flattype_sign_up_add -->
        <div id='container_addflattype'>
            <div id='addflattype'>
                <div class='about-banner'><h4 id='h4_flattype_sign_up'></h4></div>
                <div class='row_modal'>
                    <div class='col_modal_label' style='width: 35%'>
                        <label id='labelflattype_addflattype' for='flattype_addflattype'></label><br><br>
                        <label id='labelmonth_debet_sum_addflattype' for='month_debet_sum_addflattype'></label><br><br>
                        <label id='labelfield_addflattype' for='field_addflattype'></label><br><br>
                    </div>
                    <div class='col_modal'>
                        <input id='inputflattype_addflattype' type='text' name='flattype_addflattype'><br><br>
                        <input id='inputmonth_debet_sum_addflattype' type='number' style='width: 70%' name='month_debet_sum_addflattype'><br><br>
                        <input id='inputfield_addflattype' type='number' style='width: 20%' name='field_addflattype'><br><br>
                    </div>
                </div>
                <button id='flattype_save_add'></button>
                <button id='flattype_exit_add'></button>
            </div>
        </div>
<!-- flattype_edit_row -->
        <div id='container_editflattype'>
            <div id='editflattype'>
                <div class='about-banner'><h4 id='h4_flattype_edit'></h4></div>
                <div class='row_modal'>
                    <div class='col_modal_label' style='width: 35%'>
                        <label id='labelflattype_edit' for='flattype_edit'></label><br><br>
                        <label id='labelmonth_debet_sum_edit' for='month_debet_sum_edit'></label><br><br>
                        <label id='labelfield_edit' for='field_edit'></label><br><br>
                    </div>
                    <div class='col_modal'>
                            <input id='inputflattype_edit' name='flattype_edit'><br><br> 
                            <input id='inputmonth_debet_sum_edit' style='width: 70%' name='month_debet_sum_edit'><br><br> 
                            <input id='inputfield_edit' style='width: 20%' name='field_edit'><br><br> 
                    </div>
                </div>
                <button id='flattype_save_edit'></button>
                <button id='flattype_exit_edit'></button>
            </div>
        </div>
    </body>
</html>