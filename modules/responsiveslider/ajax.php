<?php

include_once('../../config/config.inc.php');
include_once('../../init.php');
include_once('responsiveslider.php');

$responsiveSlider = new ResponsiveSlider();

if (Tools::getValue('action') == 'deleteSlide') {
    $slider = new ResponsiveSliderClass(Tools::getValue('idSlide'));

    if (ResponsiveSliderClass::deleteSlide(Tools::getValue('idSlide'), __DIR__)) {
        $response = '
        <div class="conf confirm">
            '.$responsiveSlider->l('The slide').' '.$slider->title[$cookie->id_lang].' '.$responsiveSlider->l('has been deleted.').'
        </div>';
    } else {
        $response = '
        <div class="conf error">
            '.$responsiveSlider->l('An error has occured while deleting slide.').'
        </div>';
    }

    echo $response;
    exit();
}

if (Tools::getValue('action') == 'onlineSlide') {
    $slider = new ResponsiveSliderClass(Tools::getValue('idSlide'));

    if (Tools::getValue('actionOnline') == 'putOnline') {
        $slider->isonline = 1;

        $response = '
        <div class="conf confirm">
            '.$responsiveSlider->l('The slide').' '.$slider->title[$cookie->id_lang].' '.$responsiveSlider->l('is now online.').'
        </div>';
    } else {
        $slider->isonline = 0;

        $response = '
        <div class="conf confirm">
            '.$responsiveSlider->l('The slide').' '.$slider->title[$cookie->id_lang].' '.$responsiveSlider->l('is now offline.').'
        </div>';
    }

    $slider->save();
    echo $response;
    exit();
}

if (Tools::getValue('action') == 'updatePositionSlide') {
    $responsiveSlide = new ResponsiveSliderClass((int)(Tools::getValue('id_slide')));
    $positions = Tools::getValue('slides');

    if (Validate::isLoadedObject($responsiveSlide))
        if ($responsiveSlide->updatePosition($positions))
            die(true);
        else
            die('{"hasError" : true, "errors" : "Can not update slide position"}');
    else
        die('{"hasError" : true, "errors" : "This slide can not be loaded"}');

    exit();
}

exit();

?>