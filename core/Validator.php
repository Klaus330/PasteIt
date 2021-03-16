<?php


namespace app\core;

class Validator
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_UNIQUE = 'unique';
    public const RULE_MATCH = 'match';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'min';

    protected static $errors = [];



    public static function validate($data, $rulesArray)
    {
        if($rulesArray === [] || $data === [])
        {
            var_dump($rulesArray);
            throw new \InvalidArgumentException('No Rules Provided.');
        }

        foreach ($rulesArray as $attribute => $rules) {
            $value = $data[$attribute] ?? null;
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (is_array($ruleName)) {
                    $ruleName = $rule[0];
                }

                switch ($ruleName) {
                    case Validator::RULE_REQUIRED:
                        if ($value != null) {
                            self::addError($attribute, self::RULE_REQUIRED);
                        }
                        break;
                    case Validator::RULE_EMAIL:
                        if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                            self::addError($attribute, self::RULE_EMAIL);
                        }
                        break;
                    case Validator::RULE_MIN:
                        if(strlen($value) < $rule['min']){
                            self::addError($attribute, self::RULE_MIN, $rule);
                        }
                        break;
                    case Validator::RULE_MAX:
                        if(strlen($value) < $rule['max']){
                            self::addError($attribute, self::RULE_MAX, $rule);
                        }
                        break;
                    case Validator::RULE_MATCH:
                            if($value !== $data[$rule['match']]){
                                self::addError($attribute, self::RULE_MATCH, $rule);
                            }
                        break;
                }
            }
        }
        return self::$errors;
    }
}