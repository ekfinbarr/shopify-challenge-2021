<?php

namespace App\Rules;

use App\Models\School;
use Illuminate\Contracts\Validation\Rule;

class isSchoolExist implements Rule
{
  /**
   * Create a new rule instance.
   *
   * @return void
   */
  public function __construct($school = null)
  {
    $this->school = $school;
  }

  /**
   * Determine if the validation rule passes.
   *
   * @param  string  $attribute
   * @param  mixed  $value
   * @return bool
   */
  public function passes($attribute, $value)
  {
    if (!$value || !isset($value)) return true;

    $school = School::where('id', $value)->first();
    if ($school) {
      return true;
    }
    return false;
  }

  /**
   * Get the validation error message.
   *
   * @return string
   */
  public function message()
  {
    return "Invalid code ` :attribute `. No school with such code!";
  }
}
