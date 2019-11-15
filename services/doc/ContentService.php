<?php


namespace addons\RfOnlineDoc\services\doc;

use Yii;
use addons\RfOnlineDoc\common\models\Content;
use common\components\Service;
use common\enums\StatusEnum;
use common\helpers\ArrayHelper;

/**
 * Class ContentService
 * @package addons\RfOnlineDoc\services\doc
 * @author jianyan74 <751393839@qq.com>
 */
class ContentService extends Service
{
    /**
     * 获取下拉
     *
     * @param string $id
     * @return array
     */
    public function getDropDownForEdit($id = '')
    {
        $list = Content::find()
            ->where(['>=', 'status', StatusEnum::DISABLED])
            ->andFilterWhere(['merchant_id' => $this->getMerchantId()])
            ->select(['id', 'title', 'pid', 'level'])
            ->orderBy('sort asc')
            ->asArray()
            ->all();

        $list = ArrayHelper::removeByValue($list, $id);
        $models = ArrayHelper::itemsMerge($list);
        $data = ArrayHelper::map(ArrayHelper::itemsMergeDropDown($models), 'id', 'title');

        return ArrayHelper::merge([0 => '顶级'], $data);
    }

    /**
     * @return array
     */
    public function getDropDown()
    {
        $models = Content::find()
            ->where(['status' => StatusEnum::ENABLED])
            ->andWhere(['merchant_id' => Yii::$app->services->merchant->getId()])
            ->orderBy('sort asc,created_at asc')
            ->asArray()
            ->all();

        $models = ArrayHelper::itemsMerge($models);

        return ArrayHelper::map(ArrayHelper::itemsMergeDropDown($models), 'id', 'title');
    }

    /**
     * 根据关键字查询
     *
     * @param $doc_id
     * @param $keyword
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getListByKeyword($doc_id, $keyword)
    {
        $chapter = $this->getChapter($doc_id);
        $chapterIds = array_column($chapter, 'id');

        return Content::find()
            ->where(['doc_id' => $doc_id])
            ->andWhere(['status' => StatusEnum::ENABLED])
            ->andWhere(['in', 'id', $chapterIds])
            ->andWhere(['like', 'content', $keyword])
            ->orderBy('sort asc')
            ->all();
    }

    /**
     * 获取所有的下级章节
     *
     * @param $doc_id
     * @return mixed
     */
    public function getChapter($doc_id)
    {
        $data = $this->getAllByDocId($doc_id);
        $data = ArrayHelper::itemsMerge($data);

        return ArrayHelper::getNotChildRowsByItemsMerge($data);
    }

    /**
     * @param $doc_id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getAllByDocId($doc_id)
    {
        return Content::find()
            ->where(['doc_id' => $doc_id])
            ->andWhere(['status' => StatusEnum::ENABLED])
            ->select('id, uuid, doc_id, title, sort, pid')
            ->asArray()
            ->all();
    }
}