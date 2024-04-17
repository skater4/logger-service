<?php

namespace App\Models\Log;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Log\Log
 *
 * @property int $id
 * @property string $client
 * @property string $message
 * @property string $level
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Log newModelQuery()
 * @method static Builder|Log newQuery()
 * @method static Builder|Log query()
 * @method static Builder|Log whereClient($value)
 * @method static Builder|Log whereCreatedAt($value)
 * @method static Builder|Log whereId($value)
 * @method static Builder|Log whereLevel($value)
 * @method static Builder|Log whereMessage($value)
 * @method static Builder|Log whereUpdatedAt($value)
 * @method static Builder|Log whereUserId($value)
 * @mixin Eloquent
 */
class Log extends Model
{
    protected $guarded = [];

    public $timestamps = true;
    public $table = 'logs';
}
