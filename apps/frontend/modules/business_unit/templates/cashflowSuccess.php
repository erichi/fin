<?php use_helper('I18N')?>
<?php //use_stylesheet('default.css') ?>
<?php use_stylesheet('smoothness/jquery-ui-1.8.16.custom.css') ?>
<?php use_stylesheet('main.css') ?>
<?php use_javascript('jquery-ui-1.8.16.custom.min.js') ?>
<?php use_javascript('jquery.scrollTo.js') ?>
<?php use_javascript('cashflow.js') ?>
<?php use_javascript('inputmask.js') ?>
<?php use_javascript('jquery.ui.datepicker-ru.js')?>

<div id="cashflow_container" class="cashflow">
    <h1>Cashflow</h1>
    <hr>
    <div id="sf_admin_content">
        <form action="<?php echo url_for('@cashflow')?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $sf_request->getParameter('id'); ?>">
            <input type="text" name="date" id="cashflow_start_date" value="<?php echo $sf_request->getParameter('startDate', date('Y-m-d')); ?>">
        </form>

        <div class="clearfix">
            <table id="first-col" class="table table-bordered col-table">
                <thead></thead>
                <tbody></tbody>
            </table>

            <table id="last-col" class="table table-bordered col-table">
                <thead></thead>
                <tbody></tbody>
            </table>

            <div class="scrollable-table-viewport">
                <div class="scrollable-table">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><strong>Наименование</strong></th>
                                <?php foreach ($range as $r): ?>
                                <th id="<?php echo $r; ?>"><?php echo $r; ?></th>
                                <?php endforeach; ?>
                                <th><strong>Сумма</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $res): ?>
                            <tr>
                                <td>
                                <?php
                                    if(isset($res['jobOrderId'])){
                                        echo '<a href="'.url_for('job_order/edit?id='.$res['jobOrderId']).'">'.$res['name'].'</a>';
                                    }elseif(isset($res['ceBusinessUnitId'])){
                                        echo '<a href="'.url_for('business_unit/currentExpenses?id='.$res['ceBusinessUnitId']).'">'.$res['name'].'</a>';
                                    }else{
                                        echo $res['name'];
                                    }
                                ?>
                                </td>
                                <?php foreach ($res['dates'] as $date): ?>
                                <?php if(!empty($date)):?>
                                <td>
                                    <?php if(isset($date['in'])): ?>
                                    <ul class="income_payments">
                                        <?php foreach ($date['in'] as $amount): ?>
                                        <?php // if($amount != 0):?>
                                            <li>
                                                <?php include_partial('business_unit/amount', array('amount' => $amount, 'isIncome' => true))?>
                                            </li>
                                        <?php // endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                    <?php endif; ?>
                                    <?php if(isset($date['out'])): ?>
                                    <ul class="outcome_payments">
                                        <?php foreach ($date['out'] as $amount): ?>
                                        <li>
                                        <?php include_partial('business_unit/amount', array('amount' => $amount, 'isIncome' => false))?>
                                        </li>
                                        <?php endforeach; ?>

                                    </ul>
                                    <?php endif; ?>
                                </td>

                                <?php endif; ?>
                                <?php endforeach; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="dialog" id="dialog_job_payment">																					<!--Dialog box Job Payment-->
    <table>
        <tr>
            <td><label for="job_payment_name">Название платежа:</label></td>
            <td><input type="text" name="job_payment[name]" id="job_payment_name"></td>
        </tr>
        <tr>
            <td><label for="job_payment_date">Дата:</label></td>
            <td><input type="text" name="job_payment[date]" id="job_payment_date"></td>
        </tr>
        <tr>
            <td><label for="job_payment_amount">Сумма:</label></td>
            <td><input type="text" name="job_payment[amount]" id="job_payment_amount"></td>
        </tr>
        <tr id="job_payment_file_container">
            <td><label for="job_payment_file">Файл:</label></td>
            <td>
                <span id="job_payment_file"></span>
                <input type="hidden" name="job_payment[id]" id="job_payment_id">
            </td>
        </tr>
    </table>
</div>												<!--End Dialog box-->

<script type="text/javascript">
    var business_unit_id = "<?php echo $sf_request->getParameter('id') ?>";
    function IsNumeric(input)
    {
        return (input - 0) == input && input.length > 0;
    }

    $(document).ready(function(){
        $('.outcome_payments, .income_payments').each(function(){
            if($(this).has('a').length == 0 && $(this).has('img').length == 0 && IsNumeric($(this).text()) && $(this).text() != 0) {
                $(this).html('<nobr>'+$.formatNumber($(this).text(), {format:"0,000", locale:"ru"})+'</nobr>');
            }
        });

    });

</script>
