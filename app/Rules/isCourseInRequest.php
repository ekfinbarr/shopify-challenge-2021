<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class isCourseInRequest implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($course = null)
    {
        $this->course = $course;
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
        // if(!request()->input('course_id') && $value) return true;
        // return request()->input('course_id') !== '' ? true : false;
        if(!request()->input('course_id') && !$value) return false;
        else if(request()->input('course_id') || $value) return true;
        else return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
      return ':attribute must be set!';
    }
}
