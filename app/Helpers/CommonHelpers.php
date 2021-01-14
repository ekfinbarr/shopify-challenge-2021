<?php

use Brian2694\Toastr\Facades\Toastr;

// if (!function_exists('DummyFunction')) {

    // /**
    //  * description
    //  *
    //  * @param
    //  * @return
    //  */
    // function DummyFunction()
    // {

    // }
    
    /**
     * description
     *
     * @param
     * @return
     */

if (!function_exists('toast')) {
    function toast($type = null /** toast context */, $message /** message to be displayed */, $options = [])
    {
      if(!$message) return;
      $types = ['error', 'info', 'success', 'warning'];

        if (! in_array($type, $types)) {
            throw new Exception("The $type remind message is not valid.");
        }

      switch ($type) {
        case 'success':
          Toastr::success($message,'Success', $options);
          break;
        case 'error':
          Toastr::error($message,'Error', $options);
          break;
        case 'info':
          Toastr::info($message,'Info', $options);
          break;
        case 'warning':
          Toastr::warning($message,'Warning', $options);
          break;
        default:
          Toastr::info($message,'Info', $options);
          break;
      }
    }
}
