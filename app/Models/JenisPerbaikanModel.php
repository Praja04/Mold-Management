<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisPerbaikanModel extends Model
{
    protected $table            = 'jenis_perbaikan';
    protected $primaryKey       = 'id';
   
    protected $allowedFields    = ['jenis_perbaikan','val_jenis'];

  public function getjenisperbaikan()
  {
    return $this->select('jenis_perbaikan , val_jenis')
    ->orderBy('val_jenis','ASC')
    ->findAll();
  }

}
