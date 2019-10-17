<?php

namespace addons\RfOnlineDoc\backend\controllers;

use Yii;
use common\models\base\SearchModel;
use common\enums\StatusEnum;
use common\components\Curd;
use addons\RfOnlineDoc\common\models\Doc;

/**
 * Class DocController
 * @package addons\RfOnlineDoc\backend\controllers
 * @author jianyan74 <751393839@qq.com>
 */
class DocController extends BaseController
{
    use Curd;

    /**
     * @var Doc
     */
    public $modelClass = Doc::class;

    /**
     * 首页
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        $searchModel = new SearchModel([
            'model' => $this->modelClass,
            'scenario' => 'default',
            'partialMatchAttributes' => ['title'], // 模糊查询
            'defaultOrder' => [
                'sort' => SORT_ASC,
                'id' => SORT_DESC,
            ],
            'pageSize' => $this->pageSize,
        ]);

        $dataProvider = $searchModel
            ->search(Yii::$app->request->queryParams);
        $dataProvider->query
            ->andWhere(['status' => StatusEnum::ENABLED])
            ->andFilterWhere(['merchant_id' => $this->getMerchantId()]);

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'items' => Yii::$app->docServices->doc->getMapList(),
            'cates' => Yii::$app->docServices->cate->getMapList(),
        ]);
    }

    /**
     * 编辑/创建
     *
     * @return mixed
     */
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id', null);
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        $items = Yii::$app->docServices->doc->getMapList();
        unset($items[$model['id']]);

        return $this->render($this->action->id, [
            'model' => $model,
            'items' => $items,
            'cates' => Yii::$app->docServices->cate->getMapList(),
        ]);
    }
}