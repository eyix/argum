<?PHP
class argum {
  public $args;
  public $consume = array();
  private $flags = FALSE;
  function get_args() {
    $flags=array();
    $next = FALSE;
    foreach($this->args as $argIn) {
      $arg = $argIn;
      $argOut = preg_replace('%^-%', '', $argIn);
      if (preg_match('%^-%', $argIn) && strlen($argOut) > 1&& !$next) {
        $multi = str_split($argOut);
        foreach ($multi as $mArg) {
          $flags[$mArg] = TRUE;
        }
      } else if (!preg_match('%^-%', $argIn) && !$next) {
        $flags['multi'][] = $argOut;
      } else {
        if (!$next) {
          $flags[$argOut] = TRUE;
          if (in_array($argOut, $this->consume)) {
            $next = $argOut;
          }
        } else {
          $flags[$next] = $arg;
          $next = FALSE;
        }
      }
    }
    $this->flags = $flags;
  }

  function req($req) {
    if (!$this->flags) $this->get_args();
    $missing = FALSE;
    foreach ($req as $r) {
      if (!isset($this->flags[$r])) {
        $missing[] = $r;
      }
    }
    if ($missing) {
      $missingOut = '[-'.implode('], [-', $missing).']';
      $s = count($missing) > 1 ? "s" : "";
      $isare = count($missing) > 1 ? "are" : "is";
      die("Required flag$s: $missingOut".PHP_EOL);
    }
  }

  function print_args() {
    if (!$this->flags) $this->get_args();
    print_r($this->flags);
  }
}
