<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Craw extends Model
{
    protected $table = "berita";
    public $incrementing = false;
    protected $primaryKey = "berita_id";
    protected $keyType = "string";
    public $timestamps = false;

    
    protected $fillable = [ 'berita_id','berita_link','berita_judul',
                            'berita_isi','gambar_link','pdf_link',
                            'berita_tanggal'];

    
}
