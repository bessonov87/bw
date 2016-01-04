<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

?>
<div align="center" class="goroskop-out">
<div class="goro-znaki">
	<div data-zodiac="aries" class="goroskop_zodiac">&#9800;</div>
    <div data-zodiac="taurus" class="goroskop_zodiac">&#9801;</div>
    <div data-zodiac="gemini" class="goroskop_zodiac">&#9802;</div>
    <div data-zodiac="cancer" class="goroskop_zodiac">&#9803;</div>
    <div data-zodiac="leo" class="goroskop_zodiac">&#9804;</div>
    <div data-zodiac="virgo" class="goroskop_zodiac">&#9805;</div>
</div>

<?php
$i = 1;
if(is_array($xml) || is_object($xml)) {
    foreach ($xml->goro as $goroskop) {
        $goroskop_znak = $goroskop->znak;
        $goroskop_znak_en = $goroskop->znaken;
        $goroskop_data = $goroskop->data;
        $goroskop_text = $goroskop->text;

        $display = ($i == 1) ? 'style="display:block!important;"' : '';

        echo '<div id="' . $goroskop_znak_en . '" class="goro-item" ' . $display . '>
		<div class="goro-znak">' . $goroskop_znak . '</div>
		<div class="goro-data">' . $goroskop_data . '</div>
		<div class="goro-text">' . $goroskop_text . '</div>
	</div>';
        $i++;
    }
}
?>

    <div class="goro-select">
		<div class="goro-select-label"><strong>Выберите свой знак:</strong></div>
		<select name="znak" id="znak" onchange="change_znak(this.value)">
			<option value="aries">Овен</option>
			<option value="taurus">Телец</option>
			<option value="gemini">Близнецы</option>
			<option value="cancer">Рак</option>
			<option value="leo">Лев</option>
			<option value="virgo">Дева</option>
			<option value="libra">Весы</option>
			<option value="scorpio">Скорпион</option>
			<option value="sagitarius">Стрелец</option>
			<option value="capricorn">Козерог</option>
			<option value="aquarius">Водолей</option>
			<option value="pisces">Рыбы</option>
		</select>
	</div>
	<div class=\"goro-znaki\">
        <div data-zodiac="libra" class="goroskop_zodiac">&#9806;</div>
        <div data-zodiac="scorpio" class="goroskop_zodiac">&#9807;</div>
        <div data-zodiac="sagitarius" class="goroskop_zodiac">&#9808;</div>
        <div data-zodiac="capricorn" class="goroskop_zodiac">&#9809;</div>
        <div data-zodiac="aquarius" class="goroskop_zodiac">&#9810;</div>
        <div data-zodiac="pisces" class="goroskop_zodiac">&#9811;</div>
	</div>
	<div class="goro-copyright"><strong>&copy; Astrolis.Ru</strong></div>
</div>