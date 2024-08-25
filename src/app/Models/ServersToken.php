<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServersToken extends Model{
    protected $table = "servers_tokens";
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'uid';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The data type of the primary key.
     *
     * @var string
     */
    protected $keyType = 'int';
}
