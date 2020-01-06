<?php

namespace addons\RfOnlineDoc\merchant\controllers;

use Yii;
use common\traits\MerchantCurd;
use common\models\base\SearchModel;
use common\enums\StatusEnum;
use addons\RfOnlineDoc\common\models\Template;

/**
 * Class TemplateController
 * @package addons\RfOnlineDoc\merchant\controllers
 * @author jianyan74 <751393839@qq.com>
 */
class TemplateController extends BaseController
{
    use MerchantCurd;

    /**
     * @var string
     */
    public $modelClass = Template::class;

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
            ->andWhere(['>=', 'status', StatusEnum::DISABLED])
            ->andWhere(['merchant_id' => $this->getMerchantId()]);

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * 编辑
     *
     * @return mixed|string|\yii\console\Response|\yii\web\Response
     * @throws \yii\base\ExitException
     * @throws \Exception
     */
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);
        $model->type = !empty($model->type) ? $model->type : Yii::$app->request->get('type', 1); // 章节类型

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }
}