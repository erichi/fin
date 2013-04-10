<?php
if($amount instanceof sfOutputEscaperObjectDecorator){
    if($amount->getIsConfirmed() == false){
        if(!$isIncome){
            $file = $amount->getFilename();
        }
        $data = array(
            'id' => $amount->getId(),
            'name' => $amount->getName(),
            'date' => $amount->getDate('d.m.Y'),
            'amount' => $amount->getAmount(),
        );
        if(!empty($file)){
            $data['filelink'] = '<a target="_blank" href="http://'.$sf_request->getHost().'/uploads/files/'.$file.'">скачать</a> ';
        }
        echo '<a href="#" class="'.($isIncome ? 'income_payments' : 'outcome_payments').'" onclick="editPaymentDialog(\''.($isIncome ? 'in' : 'out').$amount->getId().'\','.($isIncome ? 'true' : 'false').'); return false;" id="'.($isIncome ? 'in' : 'out').$amount->getId().'" data-jo=\''.json_encode($data).'\'>'.$amount->getAmount().'</a>';
    }else{
        echo '<nobr>';
        echo image_tag('/sf/sf_admin/images/tick.png', array('alt' => 'Подтвержден', 'title' => 'Подтвержден'));
        echo '<span class="'.($isIncome ? 'income_payments' : 'outcome_payments').'">';
        echo $amount->getAmount();
        echo '</span>';
        echo '</nobr>';
    }
}else{
    if($amount instanceof sfOutputEscaperArrayDecorator ){
        if($amount[2] == true){
            echo '<nobr>';
            echo image_tag('/sf/sf_admin/images/tick.png', array('alt' => 'Все подтверждены', 'title' => 'Все подтверждены'));
            echo '<span class="'.($isIncome ? 'income_payments' : 'outcome_payments').'">';
            $close = true;
        }elseif($amount[1] == true){
            echo '<nobr>';
            echo image_tag('/images/tick2.png', array('alt' => 'Есть подтвержденные', 'title' => 'Есть подтвержденные'));
            echo '<span class="'.($isIncome ? 'income_payments' : 'outcome_payments').'">';
            $close = true;
        }
        $amount = $amount[0];

    }
    if(!$isIncome || $amount >0 ){
        echo $amount;
    }

    if(isset($close)){
        echo '</span></nobr>';
    }
}