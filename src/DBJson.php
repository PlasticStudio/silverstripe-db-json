<?php
namespace ArchiPro\Silverstripe\DbJson;

use SilverStripe\ORM\DB;
use SilverStripe\ORM\FieldType\DBField;

/**
 * Allow the creating of native JSON fields.
 */
class DBJson extends DBField
{
    public function setValue($value, $record = null, $markChanged = true)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }

        return parent::setValue($value, $record, $markChanged);
    }

    public function getValue($parse = true)
    {
        $value = parent::getValue($parse);

        if (is_string($value)) {
            return json_decode($value, true);
        }

        return $value;
    }

    public function prepValueForDB($value)
    {
        return json_encode($value);
    }
}
