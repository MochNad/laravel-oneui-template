<?php

namespace App\Traits;

use App\Exceptions\RestrictDeleteException;
use App\Helpers\ModelParser;

trait RestrictOnDelete
{
    public static function relations()
    {
        return new ModelParser(new static());
    }

    private function getClassName($model)
    {
        $tableName = explode('\\', get_class($model));
        $tableName = end($tableName);
        $tableName = preg_replace('/(?<!\ )[A-Z]/', ' $0', $tableName);
        $tableName = trim($tableName);
        $tableName = strtolower($tableName);
        return $tableName;
    }

    public static function bootRestrictOnDelete()
    {
        static::deleting(function ($model) {

            $class = new static();
            $relations = $class::relations();

            if (isset($class->tableName)) {
                $tableName = $class->tableName;
            } else {
                $tableName = $class->getClassName($model);
            }

            foreach ($relations as $relation) {
                $ignoredRelations = $class->ignoreOnDelete ?? [];

                if (in_array($relation['name'], $ignoredRelations)) {
                    continue;
                }

                $count = $model->{$relation['name']}()->count();
                if ($count > 0) {
                    $modelName = $relation['model'];
                    $modelName = $class->getClassName(new $modelName());
                    $message = 'Cannot delete ' . $tableName . ' data because there are related ' . $modelName . ' data';
                    throw new RestrictDeleteException($message);
                }
            }
        });
    }
}
