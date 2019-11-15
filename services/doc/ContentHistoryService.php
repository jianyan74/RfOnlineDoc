<?php


namespace addons\RfOnlineDoc\services\doc;

use Yii;
use addons\RfOnlineDoc\common\models\ContentHistory;
use common\components\Service;
use yii\data\Pagination;

/**
 * Class ContentHistoryService
 * @package addons\RfOnlineDoc\services\doc
 * @author jianyan74 <751393839@qq.com>
 */
class ContentHistoryService extends Service
{
    /**
     * @param $content_id
     * @throws \yii\base\InvalidConfigException
     */
    public function getListByContentId($content_id)
    {
        $data = ContentHistory::find()
            ->where(['content_id' => $content_id]);
        $pages = new Pagination(['totalCount' => $data->count(), 'pageSize' => 10, 'validatePage' => false]);
        $models = $data->offset($pages->offset)
            ->orderBy('id desc')
            ->with('member')
            ->select('id, content_id, member_id, serial_number, created_at')
            ->asArray()
            ->limit($pages->limit)
            ->all();

        foreach ($models as &$value) {
            $value['created_at'] = Yii::$app->formatter->asDatetime($value['created_at']);
        }

        return $models;
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord|null
     */
    public function findById($id)
    {
        return ContentHistory::find()
            ->where(['id' => $id])
            ->asArray()
            ->one();
    }

    /**
     * 获取上一条记录
     *
     * @param $content_id
     * @param $serial_number
     * @return array|\yii\db\ActiveRecord|null
     */
    public function prevByContentId($content_id, $serial_number)
    {
        return ContentHistory::find()
            ->where(['content_id' => $content_id])
            ->andWhere(['<', 'serial_number', $serial_number])
            ->orderBy('serial_number desc')
            ->asArray()
            ->one();
    }

    /**
     * 获取最大的历史记录id
     *
     * @param $content_id
     * @return false|int|string|null
     */
    public function getLastIdByContentId($content_id)
    {
        return ContentHistory::find()
                ->where(['content_id' => $content_id])
                ->select('id')
                ->orderBy('id desc')
                ->scalar();
    }

    /**
     * 获取最大的历史记录
     *
     * @param $content_id
     * @return false|int|string|null
     */
    public function getLastByContentId($content_id)
    {
        return ContentHistory::find()
            ->where(['content_id' => $content_id])
            ->orderBy('id desc')
            ->asArray()
            ->one();
    }

    /**
     * 获取递增
     *
     * @param $content_id
     * @return false|int|string|null
     */
    public function getSerialNumberIncrByContentId($content_id)
    {
        return ContentHistory::find()
            ->where(['content_id' => $content_id])
            ->select('serial_number')
            ->orderBy('serial_number desc')
            ->scalar() ?? 1;
    }
}