<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'issues';

  /**
   * Get the user that owns the issue/request.
   */
  public function user()
  {
      return $this->belongsTo('App\User');
  }
}
