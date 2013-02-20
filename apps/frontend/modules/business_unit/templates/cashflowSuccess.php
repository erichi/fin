<?php use_helper('I18N')?>
<?php //use_stylesheet('default.css') ?>
<?php use_stylesheet('smoothness/jquery-ui-1.8.16.custom.css') ?>
<?php use_stylesheet('main.css') ?>
<?php use_javascript('jquery-ui-1.8.16.custom.min.js') ?>
<?php use_javascript('jquery.scrollTo.js') ?>
<?php use_javascript('cashflow.js') ?>
<?php use_javascript('jquery.ui.datepicker-ru.js')?>

<div id="cashflow_container" class="cashflow">
    <h1>Cashflow</h1>
    <hr>
    <div id="sf_admin_content">
        <form action="<?php echo url_for('@cashflow')?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $sf_request->getParameter('id'); ?>">
            <input type="text" name="date" id="cashflow_start_date" value="<?php echo date('Y-m-d'); ?>">
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
                                <td><?php echo $res['name']; ?></td>
                                <?php foreach ($res['dates'] as $date): ?>
                                <?php if(!empty($date)):?>
                                <td>
                                    <?php if(isset($date['in'])): ?>
                                    <ul class="income_payments">
                                        <?php foreach ($date['in'] as $amount): ?>
                                        <?php if($amount != 0):?>
                                            <li><?php echo $amount; ?></li>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                    <?php endif; ?>
                                    <?php if(isset($date['out'])): ?>
                                    <ul class="outcome_payments">
                                        <?php $amount = 0; ?>
                                        <?php foreach ($date['out'] as $a): ?>
                                        <?php $amount += $a; ?>
                                        <?php endforeach; ?>
                                        <li><?php echo $amount; ?></li>
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

<script type="text/javascript">

    function IsNumeric(input)
    {
        return (input - 0) == input && input.length > 0;
    }
    
    $(document).ready(function(){
        $('.outcome_payments, .income_payments').each(function(){
            if(IsNumeric($(this).text()) && $(this).text() != 0) {
                $(this).html('<nobr>'+$.formatNumber($(this).text(), {format:"0,000.00", locale:"ru"})+'</nobr>');
            }
        });

    });

</script>
