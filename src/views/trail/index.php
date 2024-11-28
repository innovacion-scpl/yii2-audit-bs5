<?php

use bedezign\yii2\audit\Audit;
use yii\helpers\Html;
use yii\grid\GridView;

use bedezign\yii2\audit\models\AuditTrailSearch;
use yidas\yii\fontawesome\FontawesomeAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('audit', 'Trails');
$this->params['breadcrumbs'][] = ['label' => Yii::t('audit', 'Audit'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
FontawesomeAsset::register($this);
?>
<div class="audit-trail">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => 'yii\bootstrap5\LinkPager'
        ],
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn', 
                'template' => '{view}',    
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>', ['trail/view', 'id' => $model->id], [
                            'title' => Yii::t('app', 'ver'),
                        ]);
                    },
                ],
            ],
            'id',
            [
                'attribute' => 'entry_id',
                'class' => 'yii\grid\DataColumn',
                'value' => function ($data) {
                    return $data->entry_id ? Html::a($data->entry_id, ['entry/view', 'id' => $data->entry_id]) : '';
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'user_id',
                'label' => Yii::t('audit', 'User ID'),
                'class' => 'yii\grid\DataColumn',
                'value' => function ($data) {
                    return Audit::getInstance()->getUserIdentifier($data->user_id);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'action',
                'filter' => AuditTrailSearch::actionFilter(),
            ],
            'model',
            'model_id',
            'field',
            [
                'label' => Yii::t('audit', 'Diff'),
                'value' => function ($model) {
                    return $model->getDiffHtml();
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'created',
                'options' => ['width' => '150px'],
            ],
        ],
    ]); ?>
</div>
