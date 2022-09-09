<?php
if ( !function_exists('gc_val_input')) {
function gc_val_input($name,$val='',$otherAttr=''){
    return '<input type="text" name="'.$name.'" '.$otherAttr.' id="field-'.$name.'" value="'.$val.'">';
}
}
if ( !function_exists('gc_val_select')) {
function gc_val_select($name,$val,$ref){
    $r ='';
    foreach($ref as $k=>$i) {
        $s = $k == $val ? 'selected':'';
        $r .= '<option value="'.$k.'" '.$s.'>'.$i.'</option>';
    }
    return '<select name="'.$name.'">'.$r.'</select>';
}
}