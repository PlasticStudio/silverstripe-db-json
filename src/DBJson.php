<?php
namespace ArchiPro\Silverstripe\DbJson;

use SilverStripe\ORM\DB;
use SilverStripe\ORM\FieldType\DBField;

/**
 * Allow the creating of native JSON fields.
 */
class DBJson extends DBField
{
    public function setValue(mixed $value, $record = null, bool $markChanged = true): static
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);

            // only replace if valid JSON
            if (json_last_error() === JSON_ERROR_NONE) {
                $value = $decoded;
            }
        }

        return parent::setValue($value, $record, $markChanged);
    }

    public function getValue(): mixed
    {
        $value = parent::getValue();

        if (is_string($value)) {
            $decoded = json_decode($value, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }
        }

        return $value;
    }

    public function prepValueForDB($value): string
    {
        if (is_array($value) || is_object($value)) {
            return json_encode($value);
        }

        return (string) $value;
    }
}