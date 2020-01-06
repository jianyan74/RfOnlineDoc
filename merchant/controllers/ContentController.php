<?php

namespace addons\RfOnlineDoc\merchant\controllers;

use addons\RfOnlineDoc\merchant\forms\ContentForm;
use common\helpers\Html;
use Yii;
use yii\data\ActiveDataProvider;
use common\traits\MerchantCurd;
use common\enums\StatusEnum;
use common\helpers\StringHelper;
use common\helpers\ResultHelper;
use addons\RfOnlineDoc\common\models\Content;

/**
 * Class ContentController
 * @package addons\RfOnlineDoc\merchant\controllers
 * @author jianyan74 <751393839@qq.com>
 */
class ContentController extends BaseController
{
    use MerchantCurd;

    /**
     * @var Content
     */
    public $modelClass = Content::class;

    /**
     * @var
     */
    public $doc;

    /**
     * @var
     */
    public $doc_id;

    public function init()
    {
        parent::init();

        $this->doc_id = Yii::$app->request->get('doc_id');
        $this->doc = Yii::$app->rfOnlineDocService->doc->findById($this->doc_id);
    }

    /**
     * 首页
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Content::find()
            ->orderBy('sort asc, created_at asc')
            ->where(['doc_id' => $this->doc_id])
            ->andWhere(['>=', 'status', StatusEnum::DISABLED])
            ->andWhere(['merchant_id' => $this->getMerchantId()]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'doc_id' => $this->doc_id,
            'doc' => $this->doc,
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
        $model = $this->findFormModel($id);
        $model->doc_id = $this->doc_id;
        $model->pid = Yii::$app->request->get('pid', null) ?? $model->pid; // 父id
        $model->type = !empty($model->type) ? $model->type : Yii::$app->request->get('type', 1); // 章节类型
        !$model->uuid && $model->uuid = StringHelper::uuid('uniqid');

        if (!$model->tmp_history_id) {
            $model->tmp_history_id = Yii::$app->rfOnlineDocService->contentHistory->getLastIdByContentId($id);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'doc_id' => $this->doc_id]);
        }

        return $this->render($this->action->id, [
            'model' => $model,
            'template' => Yii::$app->rfOnlineDocService->template->findByType($model->type),
            'dropDownList' => Yii::$app->rfOnlineDocService->content->getDropDownForEdit($id),
        ]);
    }

    /**
     * 差异对比
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionDifference()
    {
        $tmp_history_id = Yii::$app->request->get('tmp_history_id');
        $content_id = Yii::$app->request->get('content_id');

        return $this->renderAjax($this->action->id, [
            'changed' => Yii::$app->rfOnlineDocService->contentHistory->getLastByContentId($content_id),
            'original' => Yii::$app->rfOnlineDocService->contentHistory->findById($tmp_history_id),
        ]);
    }

    /**
     * 历史版本
     *
     * @return array|string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionHistory()
    {
        $this->layout = '@merchant/views/layouts/default';
        $content_id = Yii::$app->request->get('content_id');

        $history = Yii::$app->rfOnlineDocService->contentHistory->getListByContentId($content_id);
        if (Yii::$app->request->get('page')){
            return ResultHelper::json(200, '获取成功', $history);
        }

        return $this->render($this->action->id, [
            'content_id' => $content_id,
            'history' => $history,
        ]);
    }

    /**
     * 还原
     *
     * @return array
     */
    public function actionRestore()
    {
        $history_id = Yii::$app->request->get('history_id');

        $model = Yii::$app->rfOnlineDocService->contentHistory->findById($history_id);
        if ($model) {
            Content::updateAll(['content' => $model['content']], ['id' => $model['content_id']]);

            return ResultHelper::json(200, '还原成功');
        }

        return ResultHelper::json(422, '还原失败');
    }

    /**
     * 获取对比的数据
     *
     * @return array
     */
    public function actionComparison()
    {
        $history_id = Yii::$app->request->get('history_id');
        // 和当前版本对比
        $is_newest = Yii::$app->request->get('is_newest');

        $original = '';
        $changed = Yii::$app->rfOnlineDocService->contentHistory->findById($history_id);
        if ($is_newest == StatusEnum::ENABLED) {
            $original = $changed;
            $changed = Yii::$app->rfOnlineDocService->contentHistory->getLastByContentId($original['content_id']);
        }

        if (!$original && !($original = Yii::$app->rfOnlineDocService->contentHistory->prevByContentId($changed['content_id'], $changed['serial_number']))) {
            $original = [];
            $original['title'] = ' ';
            $original['content'] = ' ';
            $original['serial_number'] = '0';
        }

        $original['content'] = Html::encode($original['content']);
        $changed['content'] = Html::encode($changed['content']);

        return ResultHelper::json(200, '获取成功', [
            'original' => $original,
            'changed' => $changed,
        ]);
    }


    /**
     * 伪删除
     *
     * @param $id
     * @return mixed
     */
    public function actionDestroy($id)
    {
        if (!($model = $this->modelClass::findOne($id))) {
            return $this->message("找不到数据", $this->redirect(['index', 'doc_id' => $this->doc_id]), 'error');
        }

        $model->status = StatusEnum::DELETE;
        if ($model->save()) {
            return $this->message("删除成功", $this->redirect(['index', 'doc_id' => $this->doc_id]));
        }

        return $this->message("删除失败", $this->redirect(['index', 'doc_id' => $this->doc_id]), 'error');
    }

    /**
     * 返回模型
     *
     * @param $id
     * @return \yii\db\ActiveRecord
     */
    protected function findFormModel($id)
    {
        /* @var $model \yii\db\ActiveRecord */
        if (empty($id) || empty(($model = ContentForm::findOne(['id' => $id, 'merchant_id' => $this->getMerchantId()])))) {
            $model = new ContentForm();
            return $model->loadDefaultValues();
        }

        return $model;
    }
}