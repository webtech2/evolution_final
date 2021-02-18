<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeAdaptationAdditionalData extends Model
{
    protected $table = 'changeadaptationadditionaldata';
    protected $primaryKey = 'caad_id';
    public $timestamps = false;

    public function change()
    {
        return $this->belongsTo('App\Change', 'caad_change_id');
    }    
    
    public function type()
    {
        return $this->belongsTo('App\Type', 'caad_data_type_id');
    }    
    
    public function buildData() 
    {
        $data = $this->caad_data;
        if ($this->caad_data_type_id == 'CAD0000007') {
            $dataitem = DataItem::find($data);
            $data = $dataitem->dataset->datasource->so_name.'.'.$dataitem->dataset->ds_name.'.'.$dataitem->di_name;
        } else if ($this->caad_data_type_id == 'CAD0000001') {
            if (strpos($data,'Format:') !== false) {
                $format = substr($data,strpos($data,'Format:')+8,10);
                $type = Type::where('tp_id',$format)->first()->tp_type;
                $data = str_replace($format, $type, $data);
            }
            if (strpos($data,'Velocity:') !== false) {
                $velocity = substr($data,strpos($data,'Velocity:')+10,10);
                $type = Type::where('tp_id',$velocity)->first()->tp_type;
                $data = str_replace($velocity, $type, $data);
            }
        } else if ($this->caad_data_type_id == 'CAD0000006') {
            if (strpos($data,'Data item:') !== false) {
                $item = substr($data,strpos($data,'Data item:')+11,5);
                $dataitem = DataItem::find($item);
                $data = str_replace($item, $dataitem->dataSet->dataSource->so_name.'.'.$dataitem->dataSet->ds_name.'.'.$dataitem->di_name, $data);
            }
        }
        return $data;
    }
}
