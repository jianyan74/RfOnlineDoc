<?php

namespace addons\RfOnlineDoc\frontend\controllers;


use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use common\helpers\ArrayHelper;
use common\enums\StatusEnum;
use common\helpers\AddonHelper;
use addons\RfOnlineDoc\common\models\Doc;
use addons\RfOnlineDoc\common\models\Content;

/**
 * Class ContentController
 * @package addons\RfOnlineDoc\frontend\controllers
 * @author jianyan74 <751393839@qq.com>
 */
class ContentController extends BaseController
{
    /**
     * 文档
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $uuid = Yii::$app->request->get('uuid');
        $content_id = Yii::$app->request->get('content_id');
        $keyword = Yii::$app->request->get('keyword', '');

        $model = Doc::find()
            ->where(['uuid' => $uuid])
            ->andWhere(['status' => StatusEnum::ENABLED])
            ->with(['content'])
            ->asArray()
            ->one();

        if (!$model || empty($model['content'])) {
            throw new NotFoundHttpException('未创建文档内容或找不到该文档');
        }

        // 根据关键字查找
        if ($keyword) {
            $content = Yii::$app->rfOnlineDocService->content->getListByKeyword($model['id'], $keyword);
            $defaultContent = $content[0] ?? '';
        } else {
            // 查找默认的数据
            if (!$content_id) {
                $item = ArrayHelper::getFirstRowByItemsMerge(ArrayHelper::itemsMerge($model['content']));
                $content_id = $item['uuid'];
            }

            if (!($defaultContent = Content::findOne(['uuid' => $content_id]))) {
                throw new NotFoundHttpException('找不到该文档');
            }

            // 判断菜单是否选中
            $content = $this->getRegroupContent($model['content'], $defaultContent['id']);
        }

        // 更新浏览量
        !empty($defaultContent) && Content::updateAllCounters(['view' => 1], ['id' => $defaultContent['id']]);
        Doc::updateAllCounters(['view' => 1], ['id' => $model['id']]);
        !is_array($model['nav']) && $model['nav'] = Json::decode($model['nav']);

        return $this->render($this->action->id, [
            'model' => $model,
            'versions' => Yii::$app->rfOnlineDocService->doc->getVersions($model),
            'menus' => $content,
            'keyword' => $keyword,
            'defaultContent' => $defaultContent,
        ]);
    }

    /**
     * 重组
     *
     * @param $content
     * @param $child_id
     * @return array
     */
    protected function getRegroupContent($content, $child_id)
    {
        $parents = ArrayHelper::getParents($content, $child_id);
        $parentIds = array_column($parents, 'id');
        foreach ($content as &$value) {
            if (in_array($value['id'], $parentIds)) {
                $value['is_active'] = StatusEnum::ENABLED;
            }
        }

        return ArrayHelper::itemsMerge($content);
    }
}