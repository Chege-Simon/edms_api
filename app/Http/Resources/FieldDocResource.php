<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Field;

class FieldDocResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $Field = Field::find($this->field_id);
        $this->setTypedValue($this->value, $Field->field_datatype);

        return [
            'id' => $this->id,
            'document_id' => $this->document_id,
            'field_id' => $this->field_id,
            'value' => $this->value,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    public function setTypedValue($value, $fieldDatatype)
    {
        switch ($fieldDatatype) {
            case 'int':
                $this->resource->value = intval($value);
                break;
            case 'float':
                $this->resource->value = floatval($value);
                break;
            case 'string':
                $this->resource->value = strval($value);
                break;
            case 'bool':
                $this->resource->value = boolval($value);
                break;
                // Add other data types as needed
            default:
                $this->resource->value = $value; // Keep the original value if no matching data type
                break;
        }
    }
}
