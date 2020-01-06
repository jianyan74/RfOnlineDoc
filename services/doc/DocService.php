<?php

namespace addons\RfOnlineDoc\services\doc;

use Yii;
use yii\helpers\ArrayHelper;
use common\components\Service;
use common\enums\StatusEnum;
use addons\RfOnlineDoc\common\models\Doc;

/**
 * Class DocService
 * @package addons\RfOnlineDoc\services\doc
 * @author jianyan74 <751393839@qq.com>
 */
class DocService extends Service
{
    /**
     * @param $id
     * @return Doc|null
     */
    public function findById($id)
    {
        return Doc::findOne($id);
    }

    /**
     * @return array
     */
    public function getMapList()
    {
        $items = Doc::find()
            ->where(['status' => StatusEnum::ENABLED])
            ->andWhere(['pid' => 0])
            ->asArray()
            ->all();
        $items = ArrayHelper::map($items, 'id', 'title');

        return ArrayHelper::merge([0 => '顶级系列'], $items);
    }

    /**
     * 更新章节数量
     *
     * @param $id
     */
    public function updateChapterNumberById($id)
    {
        $chapter = Yii::$app->rfOnlineDocService->content->getChapter($id);

        Doc::updateAll(['chapter_number' => count($chapter)], ['id' => $id]);
    }

    /**
     * 获取系列版本
     *
     * @param $doc
     * @return array
     */
    public function getVersions($doc)
    {
        if ($doc['pid'] > 0) {
            $models = Doc::find()
                ->where(['or', ['pid' => $doc['pid']], ['id' => $doc['pid']]])
                ->andWhere(['status' => StatusEnum::ENABLED])
                ->asArray()
                ->all();
        } else {
            $models = Doc::find()
                ->where(['pid' => $doc['id']])
                ->andWhere(['status' => StatusEnum::ENABLED])
                ->asArray()
                ->all();

            $models[count($models)] = $doc;
        }

        return ArrayHelper::map($models, 'uuid', 'version');
    }
}