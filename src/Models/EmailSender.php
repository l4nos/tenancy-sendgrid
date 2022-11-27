<?php

namespace Lanos\SendgridTenancy\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns;

class EmailSender extends Model
{

    use Concerns\CentralConnection,
        Concerns\EnsuresDomainIsNotOccupied,
        Concerns\ConvertsDomainsToLowercase,
        Concerns\InvalidatesTenantsResolverCache;

    protected $casts = [
        "dkim_setup" => "object"
    ];

    protected $guarded = ['tenant_id'];

    protected $table = 'email_authentication';

    public function tenant()
    {
        return $this->belongsTo(config('tenancy.tenant_model'));
    }

}