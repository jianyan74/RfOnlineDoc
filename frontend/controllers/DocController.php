<?php

namespace addons\RfOnlineDoc\frontend\controllers;

use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
use common\enums\StatusEnum;
use common\helpers\AddonHelper;
use addons\RfOnlineDoc\common\models\Doc;

/**
 * Class DocController
 * @package addons\RfOnlineDoc\frontend\controllers
 * @author jianyan74 <751393839@qq.com>
 */
class DocController extends BaseController
{
    /**
     * @var array
     */
    public $config;

    /**
     * @throws UnauthorizedHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $this->config = AddonHelper::getConfig();
        if (isset($this->config['open_plaza']) && empty($this->config['open_plaza'])) {
            throw new UnauthorizedHttpException('广场已关闭');
        }
    }

    /**
     * 文档
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $keyword =  Yii::$app->request->get('keyword');
        $cate_id =  Yii::$app->request->get('cate_id');

        $data = Doc::find()
            ->where(['status' => StatusEnum::ENABLED])
            ->andFilterWhere(['cate_id' => $cate_id])
            ->andFilterWhere(['like', 'title', $keyword])
            ->andFilterWhere(['merchant_id' => $this->getMerchantId()]);
        $pages = new Pagination(['totalCount' => $data->count(), 'pageSize' => 9]);
        $models = $data->offset($pages->offset)
            ->orderBy('sort asc, id desc')
            ->asArray()
            ->limit($pages->limit)
            ->all();

        return $this->render('index',[
            'models' => $models,
            'pages' => $pages,
            'keyword' => $keyword,
            'config' => $this->config,
            'cate_id' => $cate_id,
            'cates' => Yii::$app->rfOnlineDocService->cate->getMapList(),
        ]);
    }
}