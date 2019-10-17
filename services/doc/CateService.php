<?php


namespace addons\RfOnlineDoc\services\doc;

use common\components\Service;
use common\helpers\ArrayHelper;
use common\enums\StatusEnum;
use addons\RfOnlineDoc\common\models\Cate;

/**
 * Class CateService
 * @package addons\RfOnlineDoc\services\doc
 * @author jianyan74 <751393839@qq.com>
 */
class CateService extends Service
{
    /**
     * @return array
     */
    public function getMapList()
    {
        return ArrayHelper::map($this->getList(), 'id', 'title');
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getList()
    {
        return Cate::find()
            ->where(['status' => StatusEnum::ENABLED])
            ->andFilterWhere(['merchant_id' => $this->getMerchantId()])
            ->orderBy('sort asc, id desc')
            ->asArray()
            ->all();
    }
}