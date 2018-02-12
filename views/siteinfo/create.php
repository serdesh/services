<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Siteinfo */

$this->title = 'Добавление информации';
$this->params['breadcrumbs'][] = ['label' => 'Информация для сайта', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container siteinfo-create">
    <!--<div class="help-block"><span class="glyphicon glyphicon-question-sign"> Помощь</span></div>-->
    <?php
    Modal::begin([
        'header' => '<h2>Информация по заполнению полей</h2>',
        'toggleButton' => [
            'label' => 'Помощь',
            'class' => 'btn btn-info helpblock'
        ],
        'footer' => 'По всем вопросам обращаться к Дешковичу С.С. тел: 5-06-25'
    ])
    ?>
    <blockquote>
        <p>Поле <b><mark>Наименование информации</mark></b> должно содержать заголовок информации, отображаемый на сайте. <small> Например: "Информация о структурных подразделениях"</small></p>
    </blockquote>
    <blockquote>
        <p>В выпадающем списке <b><mark>Раздел</mark></b> должно быть выбрано одно из значений. В выбранном разделе будет размещена информация на сайте</p>
    </blockquote>
    <blockquote>
        <p>Поле <b><mark>Текст информации</mark></b> может содержать любой текст, в том числе и содержание информации.</p>
        <footer>Если информация содержит таблицы, схемы и другие сложные элементы информацию обязательно необходимо прикрепить в виде файла</footer>
    </blockquote>
    <blockquote>
        В поле <b><mark>Дата завершения публикации</mark></b> необходимо выбрать дату только в случае если информация размещается в разделах:
        <ul>
            <li>Объявления, официальная информация</li>
            <li>Оперативная информация</li>
        </ul>
        <footer>В случае выбора даты завершения публикации отличной от сегодняшнего дня, по наступлению выбранной даты - информация будет удалена</footer>
    </blockquote>
    <blockquote>
        Кнопка <b><mark>Выбрать файлы</mark></b>. По нажатию данной кнопки к информации можно прикрепить файлы. Для выбора нескольких файлов используйте кнопки <kbd>SHIFT</kbd> или <kbd>CTRL</kbd><br>Файлы выбираются все и сразу!
    </blockquote>
    <blockquote>
        Кнопка <b><mark>Добавить</mark></b> отправляет все данные на сервер для последующего размещения Дешковичем С.С. на сайте администрации района
    </blockquote>
    <?php Modal::end() ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>



</div>
