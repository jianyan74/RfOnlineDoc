<?php

namespace addons\RfOnlineDoc\merchant\forms;

use Yii;
use addons\RfOnlineDoc\common\models\Content;
use common\enums\StatusEnum;

/**
 * Class ContentForm
 * @package addons\RfOnlineDoc\merchant\forms
 * @author jianyan74 <751393839@qq.com>
 */
class ContentForm extends Content
{
    /**
     * 强制提交
     *
     * @var int
     */
    public $is_compel = 0;

    /**
     * 历史最新id
     *
     * @var
     */
    public $tmp_history_id;

    /**
     * @var
     */
    public $is_difference = 0;

    public function rules()
    {
        $rule = parent::rules();
        $rule[] = [['is_compel', 'tmp_history_id',], 'integer'];
        $rule[] = [['content'], 'verifyContent'];

        return $rule;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['is_compel'] = '强制提交';

        return $attributeLabels;
    }

    /**
     * @param $attribute
     */
    public function verifyContent($attribute)
    {
        if ($this->is_compel == StatusEnum::DISABLED) {
            $tmp_history_id = Yii::$app->rfOnlineDocService->contentHistory->getLastIdByContentId($this->id);

            if (!empty($tmp_history_id) && $tmp_history_id != $this->tmp_history_id) {
                $this->is_difference = StatusEnum::ENABLED;
                $this->addError($attribute, '检测到当前章节已被修改，可勾选强制提交进行保存，会覆盖之前保存信息，请谨慎操作');
            }
        }
    }
}