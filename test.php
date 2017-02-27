<?PHP
require_once('argum.php');

$a = new argum();
$args = $argv;
unset($args[0]);
$a->args = $args;
$a->consume = array(
  "i",
  "o"
);
$a->req( array (
  "i",
  "o"
));
$a->print_args();
