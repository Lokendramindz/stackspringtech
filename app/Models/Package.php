<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Package extends Model {
    protected $guarded = [];
    protected $casts = ['active' => 'boolean', 'featured' => 'boolean'];
    public function featureList(): array { return array_values(array_filter(array_map('trim', explode("\n", (string) $this->features)))); }
}
