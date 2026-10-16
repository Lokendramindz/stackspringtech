<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Package extends Model {
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = ['active' => 'boolean', 'featured' => 'boolean'];
    public function featureList(): array { return array_values(array_filter(array_map('trim', explode("\n", (string) $this->features)))); }
}
