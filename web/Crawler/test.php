<?php
/**
 * Created by PhpStorm.
 * User: liaoth3
 * Date: 15-10-10
 * Time: 上午10:41
 */
// start profiling
function f(){
    echo "hello world";
}
xhprof_enable();
// xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY); // 允许CPU和内存输出
// run program
// stop profiler
require_once 'index.php';

$xhprof_data = xhprof_disable();
//
// Saving the XHProf run
// using the default implementation of iXHProfRuns.
//
$XHPROF_ROOT = dirname(__FILE__) . "/../lib/xhprof";//这里填写的就是你的xhprof的路径
include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";

$xhprof_runs = new XHProfRuns_Default();

// Save the run under a namespace "xhprof_foo".
//
// **NOTE**:
// By default save_run() will automatically generate a unique
// run id for you. [You can override that behavior by passing
// a run id (optional arg) to the save_run() method instead.]
//
$run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_foo");

echo "---------------\n".
    "Assuming you have set up the http based UI for \n".
    "XHProf at some address, you can view run at \n".
    "<a href='http://localhost/web/lib/xhprof/xhprof_html/index.php?run=$run_id&source=xhprof_foo'>clickme\n";



