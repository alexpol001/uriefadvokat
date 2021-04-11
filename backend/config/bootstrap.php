<?php
Yii::$container->set('dominus77\tinymce\TinyMce', [
    'options' => [
        'rows' => 10,
        'placeholder' => true,
        'class' => 'form-control'
    ],
    'language' => 'ru',
    'clientOptions' => [
        'menubar' => true,
        'statusbar' => true,
        'theme' => 'modern',
        'plugins' => [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "template paste textcolor colorpicker textpattern imagetools codesample toc noneditable",
        ],
        'noneditable_noneditable_class' => 'fa',
        'extended_valid_elements' => 'span[class|style]',
        'toolbar1' => "undo redo | insert | fontsizeselect | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        'toolbar2' => "print preview media | forecolor backcolor emoticons | codesample",
        'fontsize_formats' => "8px 10px 12px 14px 16px 20px 24px 32px 40px 48px 56px",
        'image_advtab' => true,
    ],
    'fileManager' => [
        'class' => \dominus77\tinymce\components\MihaildevElFinder::className(),
    ],
]);
