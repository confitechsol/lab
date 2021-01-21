<?php

$placeholder = $placeholder ?? '';
$options = $options ?? [];

$models = $models ?? null;

if( $placeholder ){
    $options = array_merge( [ '' => $placeholder ], $options );
}

if( $models ){
    $model_key = $model_key ?? 'id';
    $model_label = $model_label ?? 'id';
    foreach ( $models as $model ){
        $options[ $model->$model_key ] = $model->$model_label;
    }
}

?>
@include('common.inputs.select', [ 'options' => $options ])